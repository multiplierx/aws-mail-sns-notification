<?php

namespace Multiplier\AwsMailSnsNotification\Middlewares;

use Closure;
use Dlimars\Tenant\TenantManager;
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
        $notificationMessage = new NotificationMessage();
        $notificationMail = new NotificationMail($notificationMessage->getMail());

        $request->replace([
            'message' => $notificationMessage,
            'mail' => $notificationMail
        ]);

        $notificationMailTenant = $notificationMail->getHeaders()->getTenant();
        $this->tenantManager->setCurrentTenant($notificationMailTenant);

        if ($this->tenantManager->reconnectDatabaseUsing($notificationMailTenant)) {
            return $next($request);
        }
    }
}