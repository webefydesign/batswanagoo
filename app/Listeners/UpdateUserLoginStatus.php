<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Carbon\Carbon;

class UpdateUserLoginStatus
{
    public function handle(Login $event)
    {
        $event->user->update([
            'is_login' => 1,
            'login_datetime' => Carbon::now(),
        ]);
    }
}