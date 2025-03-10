<?php

namespace App\Console\Commands;

use App\Models\ScheduledNotification;
use Exception;
use Illuminate\Console\Command;

class SendScheduledNotificationsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:scheduled-notifications';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends scheduled notifications to the users';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $notificationsToSend = ScheduledNotification::query()
            ->where('sent', false)
            ->where('processing', false)
            ->where('tries', '<=', config('app.notification.attempt'))
            ->where('scheduled_at', '<=', now()->format('Y-m-d H:i'))
            ->get();

        // Lock jobs as processing
        ScheduledNotification::query()
            ->whereIn('id', $notificationsToSend->pluck('id'))
            ->update(['processing' => true]);

        foreach ($notificationsToSend as $notification) {
            try {
                $notification->send();
            } catch (Exception $exception) {
                $notification->increment('tries');
                $notification->update(['processing' => false]);
            }
        }
    }
}
