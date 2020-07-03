<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Session;

class RegisterKPBI extends Mailable
{
    use Queueable, SerializesModels;

    public $verifyURL;
    public $user;
    public $password;
    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($verifyURL, $user)
    {
        $this->verifyURL = $verifyURL;
        $this->user = $user;
        $this->password = Session::get('temp')['password'];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.RegisterKPBI')
                    ->subject(__('kpbi.mail.subject'));
    }
}
