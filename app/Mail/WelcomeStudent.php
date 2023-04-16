<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class WelcomeStudent extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;
    protected $url;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
        $this->url = url('/');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
                    ->from('admin@virtualacademy.ph')
                    ->subject( 'Welcome to Virtual Academy PH!')
                    ->view('mails.welcome')
                    ->with([
                        'firstname' => $this->user->firstname,
                        'url'       => $this->url,

                    ]);
    }
}
