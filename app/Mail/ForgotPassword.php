<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;
use App\Token;

class ForgotPassword extends Mailable
{
    use Queueable, SerializesModels;

    protected $token, $request, $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Token $token, Request $request)
    {
        $this->user = $token->user;
        $this->token = $token;
        $this->request = $request;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $url = url('/');


        return $this->from('admin@virtualacademy.ph')
                    ->subject('Virtual Assistant PH - resetting your password')  
                    ->view('mails.forgot-password')
                    ->with([
                        'token' => $this->token,
                        'user'=> $this->user,
                        'url' => $url

                    ]);
    }
}
