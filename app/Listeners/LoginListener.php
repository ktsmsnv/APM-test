<?php

namespace App\Listeners;

use App\Events\LoginEvent;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;

class LoginListener
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
    // Add Login Event
    public function handle(LoginEvent $event): void
    {
        $time = Carbon::now()->toDateTimeString();
        $username = $event->username;
        $email = $event->email;
        DB::table('Login_history')->insert([
            'name'=>$username,
            'email'=>$email,
            'created_at'=>$time,
            'updated_at'=>$time
        ]);
    }
}
