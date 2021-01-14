<?php

namespace Multiplier\AwsMailSnsNotification\Models;

class NotificationMessage
{
    /**
     * The notification message
     * @var object
     */
    private $message;

    /**
     * The notification event type
     * @var string
     */
    private $eventType;

    /**
     * The notification original mail
     * @var object
     */
    private $mail;

    public function __construct($message)
    {
        $this->message = $message;
        $this->eventType = $this->message->eventType;
        $this->mail = $this->message->mail;
    }

    /**
     * Return the notification message
     * @return object
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Return the notification event type
     * @return string
     */
    public function getEventType()
    {
        return $this->eventType;
    }

    /**
     * Return the notification original mail
     * @return object
     */
    public function getMail()
    {
        return $this->mail;
    }
}
