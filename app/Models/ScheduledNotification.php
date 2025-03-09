<?php

namespace App\Models;

use App\Jobs\ProcessNotificationJob;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ScheduledNotification extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'notification_class',
        'notifiable_id',
        'notifiable_type',
        'sent',
        'processing',
        'scheduled_at',
        'sent_at',
        'tries',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'sent' => 'boolean',
            'processing' => 'boolean',
        ];
    }

    public function send(): void
    {
        dispatch(new ProcessNotificationJob($this->id));
    }

    /**
     * Get the user that owns the scheduled notification.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the parent notifiable model.
     */
    public function notifiable(): MorphTo
    {
        return $this->morphTo();
    }
}
