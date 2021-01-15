<?php

namespace Multiplier\AwsMailSnsNotification\Models;

use Illuminate\Support\Collection;

class NotificationMessage
{
    /**
     * The notification message
     * @var object
     */
    private $message;

    /**
     * The message event type
     * @var string
     */
    private $messageEventType;

    /**
     * The notification original mail
     * @var object
     */
    private $mail;

    /**
     * The message possible event types
     * @var array
     */
    private static $messageEventTypes = [
        'bounce',
        'complaint',
        'delivery',
        'send',
        'reject',
        'open',
        'click',
        'failure',
        'deliveryDelay'
    ];

    /**
     * The message event collection
     * @var Collection
     */
    private $messageEvent;

    public function __construct($message)
    {
        $this->message = new Collection($message);
        $this->setReceivedMessageEvent($this->message);
        $this->setEventType($this->messageEvent);
        $this->mail = $this->message->get('mail');
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
     * Return the message event type
     * @return string
     */
    public function getMessageEventType()
    {
        return $this->messageEventType;
    }

    /**
     * Return the message event
     * @return Collection
     */
    public function getMessageEvent()
    {
        return $this->messageEvent;
    }

    /**
     * Return the notification original mail
     * @return object
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * Set the message event
     * @param Collection $message
     * @return void
     */
    public function setReceivedMessageEvent($message)
    {
        $messageEventTypes = collect(self::$messageEventTypes);

        $this->messageEvent = $message->filter(function ($message, $messageKey) use ($messageEventTypes) {
            return $messageEventTypes->contains($messageKey);
        });
    }

    /**
     * Set the message event type
     * @param Collection $eventType
     * @return void
     */
    public function setEventType($eventType)
    {
        $this->messageEventType = $eventType->keys()->first();
    }
}
