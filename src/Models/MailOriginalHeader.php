<?php

namespace Multiplier\AwsMailSnsNotification\Models;

use Illuminate\Support\Collection;

class MailOriginalHeader
{
    /**
     * A collection with mail original headers
     * @var Illuminate\Support\Collection
     */
    private $headers;

    public function __construct($headers)
    {
        $this->headers = (new Collection($headers))
            ->mapWithKeys(function ($header) {
                return [ $header->name => $header->value ];
            });
    }

    /**
     * Return all email headers
     * @return array
     */
    public function getAllHeaders()
    {
        return $this->headers->all();
    }

    /**
     * Return the email sender
     * @return mixed
     */
    public function getSender()
    {
        return $this->headers->get('From');
    }

    /**
     * Return the email recipients
     * @return mixed
     */
    public function getRecipients()
    {
        return $this->headers->get('To');
    }

    /**
     * Return the email subject
     * @return mixed
     */
    public function getSubject()
    {
        return $this->headers->get('Subject');
    }

    /**
     * Return the email Tenant
     * @return mixed
     */
    public function getTenant()
    {
        return $this->headers->get(config('mail_sns_notification.header_tenant_name'));
    }

    /**
     * Return the email identifier
     * @return mixed
     */
    public function getIdentifier()
    {
        return $this->headers->get(config('mail_sns_notification.header_mail_identifier'));
    }


}