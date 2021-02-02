<?php

namespace App\Mail;

use App\User;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
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
    public function build($newPassword)
    {

        //$data = array(['newPassword' => $newPassword, 'user' => $user]);

        $user = $this->user;       

        try {
            return $this->from('raphael.falcao@satcompany.com.br', 'Raphael Falcão')
                ->to($user->email)
                ->text('emails.resetmail', compact(['user', 'newPassword']));
        } catch (Exception $e) {
            return $e;
        }
    }
}
