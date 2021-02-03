<?php

namespace App\Mail;

use App\User;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Hash;
use Mail;

class ResetEmail extends Mailable
{
    use Queueable, SerializesModels;

    private $data;
    private $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        $password = rand(100000, 999999);

        $this->user->update(['password' => Hash::make($password)]);

        return $this->from('revendas@satcompany.com.br', 'Sat Company')
            ->to($this->user->email, $this->user->name)
            ->subject('SatCompany :: Nova Senha')
            ->view('emails.reset_mail', ['user' => $this->user, 'password' => $password]);
    }
}
