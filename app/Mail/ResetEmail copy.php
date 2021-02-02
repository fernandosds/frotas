<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Mail;

class ResetEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function sendEmailResetPassword($newPassword, $user)
    {
        //$data = array('name' => "Virat Gandhi");
        $data = array(['newPassword' => $newPassword, 'user' => $user]);
        Mail::send('emails.resetmail', $data, function ($message) {
            $message->to('raphalcao@gmail.com', 'Tutorials Point')->subject('Laravel HTML Testing Mail');
            $message->from('raphael.falcao@satcompany.com.br', 'Virat Gandhi');
        });
        echo "HTML Email Sent. Check your inbox.";

        // return $this->from('raphael.falcao@satcompany.com.br', 'Raphael Falcão')
        //    ->to('raphalcao@gmail.com')
        //   ->view('emails.resetmail', compact(['user', 'newPassword']));
    }
}
