<?php

namespace App\Listeners;

use App\Events\BookingDeletedEvent;

class BookingDeletedListener
{
    /**
     * Create the event listener.
     */
    public function __construct() {}

    /**
     * Handle the given event.
     */
    public function handle(BookingDeletedEvent $event): void
    {
        $event->booking->scheduledNotifications()
            ->where('user_id', $event->booking->user_id)
            ->delete();
    }
}
