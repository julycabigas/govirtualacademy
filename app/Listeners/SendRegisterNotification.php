<?php

namespace App\Listeners;

use App\Events\RegisterConfirmation;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Mail\WelcomeStudent;
use Mail;
use App\User;

class SendRegisterNotification
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
    public function handle(RegisterConfirmation $event)
    {
        $user = $event->user;


        // Send email to Admin
        Mail::to('julycabigas@yahoo.com')->send(new WelcomeStudent($user));
    }
}
