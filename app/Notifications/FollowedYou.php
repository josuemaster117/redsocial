<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class FollowedYou extends Notification
{
    use Queueable;

    public function __construct(public int $followerId, public string $followerName)
    {
    }

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable): array
    {
        return [
            'type' => 'follow',
            'follower_id' => $this->followerId,
            'follower_name' => $this->followerName,
            'message' => "{$this->followerName} empezó a seguirte",
        ];
    }
}
