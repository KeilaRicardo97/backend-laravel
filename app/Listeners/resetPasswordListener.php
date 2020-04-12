<?php

namespace App\Listeners;

use App\Events\resetPassword;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Mail\userPasswordReset;
use Illuminate\Support\Facades\Mail;


class resetPasswordListener
{
    public function __construct()   
    {
        //
    }


    public function handle(resetPassword $event)
    {
        // var_dump($event->datos->verification_token);
        Mail::to($event->datos->email)->send(new userPasswordReset($event->datos));
 
    }
}
 