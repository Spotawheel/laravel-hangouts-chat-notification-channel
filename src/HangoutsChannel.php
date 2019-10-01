<?php

namespace NotificationChannels\Hangouts;

use NotificationChannels\Hangouts\Exceptions\CouldNotSendNotification;
use Illuminate\Notifications\Notification;

class HangoutsChannel
{
    /**
     * @var \NotificationChannels\Hangouts\Hangouts
     */
    protected $hangouts;

    /**
     * @param \NotificationChannels\Hangouts\Hangouts $hangouts
     */
    public function __construct(Hangouts $hangouts)
    {
        $this->hangouts = $hangouts;
    }

    /**
     * Send the given notification.
     *
     * @param mixed $notifiable
     * @param \Illuminate\Notifications\Notification $notification
     *
     * @return array
     *
     * @throws \NotificationChannels\Hangouts\Exceptions\CouldNotSendNotification
     */
    public function send($notifiable, Notification $notification)
    {
        $space = $notifiable->routeNotificationFor('hangouts');
        if (empty($space)) {
            throw new CouldNotSendNotification('Notifiable must have a routeNotificationFor() space');
        }

        $message = $notification->toHangouts($notifiable);

        return $this->hangouts->send($space, $message);
    }
}
