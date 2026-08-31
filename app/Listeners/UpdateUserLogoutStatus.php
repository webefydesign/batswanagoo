<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Logout;

class UpdateUserLogoutStatus
{
    public function handle(Logout $event)
    {
        if ($event->user) {
            $event->user->update([
                'is_login' => 0,
            ]);
        }
    }
}