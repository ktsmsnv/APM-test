<?php

namespace App\Listeners;

use App\Events\LoginEvent;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request; // Использование фасада Request

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
        $ipAddress = Request::ip(); // Получение IP-адреса пользователя
        DB::table('Login_history')->insert([
            'name'=>$username,
            'email'=>$email,
            'ip_address' => $ipAddress, // Запись IP-адреса в базу данных
            'created_at'=>$time,
            'updated_at'=>$time
        ]);
    }
}
