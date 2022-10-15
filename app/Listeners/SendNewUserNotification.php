<?php

namespace App\Listeners;

use App\Events\RegisteredUser;
use App\Models\User;
use App\Notifications\NewUserNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;
use Pusher\Pusher;

class SendNewUserNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $admins = User::whereHas('roles', function($query) {
            $query->where('id', 1);
        })->get();

        event(new RegisteredUser(['user' => $event->user]));
        Notification::send($admins, new NewUserNotification($event->user));

    }
}
