<?php

namespace App\Listeners;

use App\Events\BookingCreatedEvent;
use Carbon\CarbonImmutable;

class BookingCreatedListener
{
    /**
     * Create the event listener.
     */
    public function __construct() {}

    /**
     * Handle the given event.
     */
    public function handle(BookingCreatedEvent $event): void
    {
        $booking = $event->booking;
        $booking->load('user');
        $startTime = CarbonImmutable::parse(toUserDateTime($booking->start, $booking->user), $booking->user->timezone);

        $booking->createReminderNotifications($booking, $startTime);
    }
}
