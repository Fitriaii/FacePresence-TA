<?php

namespace App\Listeners;

use App\Models\User;
use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Carbon;

class UpdateLastLogin
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Login $event): void
    {
        if ($event->user instanceof User) {
            $event->user->last_login_at = Carbon::now();
            $event->user->save();
        } else {
            // Kalau bukan, coba panggil ulang model User via id
            $user = User::find($event->user->id);

            if ($user) {
                $user->last_login_at = Carbon::now();
                $user->save();
            }
        }
    }
}
