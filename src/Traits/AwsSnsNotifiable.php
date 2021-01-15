<?php

namespace Multiplier\AwsMailSnsNotification\Traits;

use Dlimars\Tenant\Facades\Tenant;

trait AwsSnsNotifiable
{
    /**
     * The AWS SES Configuration Set name to be associated to the email
     * @var string
     */
    protected $sesConfigurationSetName;

    /**
     * The email associated tenant
     * @var string
     */
    protected $tenantName;

    /**
     * The email unique identifier
     * @var string
     */
    protected $mailIdentifier;

    /**
     * Set the required headers to the email (AWS SES ConfigurationSet, TenantName, MailIdentifier)
     * @param string $sesConfigurationSetName
     * @param string $mailIdentifier
     * @param string $tenantName
     */
    protected function awsSnsNotification(
        string $sesConfigurationSetName,
        string $mailIdentifier,
        string $tenantName = ''
    ) {
        $this->sesConfigurationSetName = $sesConfigurationSetName;
        $this->mailIdentifier = $mailIdentifier;
        $this->tenantName = $tenantName ? $tenantName : Tenant::getCurrentTenant();

        return $this->withSwiftMessage(function ($message) {
            $message->getHeaders()->addTextHeader('X-SES-CONFIGURATION-SET', $this->sesConfigurationSetName);
            $message->getHeaders()->addTextHeader(config('mail_sns_notification.header_tenant_name'), $this->tenantName);
            $message->getHeaders()->addTextHeader(config('mail_sns_notification.header_mail_identifier'), $this->mailIdentifier);
        });
    }
}
