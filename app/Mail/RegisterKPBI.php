<?php

namespace App\Mail;

use App\Helper\FlashMsg;
use App\KPBI;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;
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
    public function __construct($verifyURL, User $user)
    {
        $user_profile = $user->kpbi_profile;
        $profile_info = $user_profile->attributesToArray();
        
        $this->verifyURL = $verifyURL;
        $this->user = $user;
        $this->password = KPBI::generateLoginCredentials($profile_info)['password'];
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
