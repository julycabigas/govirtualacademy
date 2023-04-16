<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CourseCertificate extends Mailable
{
    use Queueable, SerializesModels;

    protected $user, $url;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user)
    {

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
                    ->from('admin@pinoytuts.com')
                    ->subject( 'Your certificate from Pinoy Tutus!')
                    ->view('mails.certificate')
                    ->with([
                        'url'   => $this->url,

                    ]);
    }
}
