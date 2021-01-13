<?php

namespace Multiplier\AwsMailSnsNotification\Models;

use Multiplier\AwsMailSnsNotification\Models\MailOriginalHeader;

class NotificationMail
{
    /**
     * The mail destinations (recipients)
     * @var array
     */
    private $destination;

    /**
     * The mail original headers
     * @var MailOriginalHeader
     */
    private $originalHeaders;

    public function __construct($mail)
    {
        $this->destination = $mail->destination;
        $this->originalHeaders = new MailOriginalHeader($mail->headers);
    }

    /**
     * Return the mail destinations (recipients)
     * @return array
     */
    public function getDestination()
    {
        return $this->destination;
    }

    /**
     * Return the mail original headers
     * @return MailOriginalHeader
     */
    public function getHeaders()
    {
        return $this->originalHeaders;
    }
}
