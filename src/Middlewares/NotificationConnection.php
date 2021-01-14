<?php

namespace Multiplier\AwsMailSnsNotification\Middlewares;

use Closure;
use Aws\Sns\Message;
use Aws\Sns\MessageValidator;
use Dlimars\Tenant\TenantManager;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;
use Multiplier\AwsMailSnsNotification\Models\NotificationMessage;
use Multiplier\AwsMailSnsNotification\Models\NotificationMail;

class NotificationConnection
{
    /**
     * @var TenantManager
     */
    protected $tenantManager;

    public function __construct(TenantManager $tenantManager)
    {
        $this->tenantManager = $tenantManager;
    }

    public function handle($request, Closure $next)
    {
        $message = Message::fromRawPostData();

        $validator = new MessageValidator();

        if ($validator->isValid($message)) {

            $request->request->add([
                'notificationType' => $message['Type']
            ]);

            if ($message['Type'] === 'SubscriptionConfirmation') {

                // Confirm the subscription by sending a GET request to the SubscribeURL
                Log::info($message['SubscribeURL']);

                $client = new Client();
                $client->get($message['SubscribeURL']);

                $next($request);

            } elseif ($message['Type'] === 'Notification') {

                $notificationMessage = new NotificationMessage(json_decode($message['Message']));
                $notificationMail = new NotificationMail($notificationMessage->getMail());

                $request->request->add([
                    'message' => $notificationMessage,
                    'mail' => $notificationMail
                ]);

                $notificationMailTenant = $notificationMail->getHeaders()->getTenant();
                $this->tenantManager->setCurrentTenant($notificationMailTenant);

                if ($this->tenantManager->reconnectDatabaseUsing($notificationMailTenant)) {
                    return $next($request);
                }

            } elseif ($message['Type'] === 'UnsubscribeConfirmation') {

                // Unsubscribed in error? You can resubscribe by visiting the endpoint
                // provided as the message's SubscribeURL field.
                Log::info('SNS Resubscribe URL' . $message['SubscribeURL']);

                $next($request);
            }
        }
    }
}
