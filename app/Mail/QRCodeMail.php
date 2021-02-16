<?php

namespace App\Mail;

use App\Services\ApiUserService;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class QRCodeMail extends Mailable
{
    use Queueable, SerializesModels;

    private $user;
    private $apiUserService;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, ApiUserService $apiUserService)
    {
        //
        $this->user = $user;
        $this->apiUserService = $apiUserService;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        $qrcode = $this->apiUserService->generateQRCode($this->user->validation_token);

        return $this->from('revendas@satcompany.com.br', 'Sat Company')
            ->to($this->user->email, $this->user->name)
            ->subject('SatCompany :: QRCode de validação')
            ->view('emails.qrcode', ['user' => $this->user, 'qrcode' => $qrcode]);

    }
}
