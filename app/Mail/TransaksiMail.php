<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TransaksiMail extends Mailable
{
    use SerializesModels;

    public $transaksi;
    public $user;
    public $isBaru;

    public function __construct($transaksi, $user, $isBaru)
    {
        $this->transaksi = $transaksi;
        $this->user = $user;
        $this->isBaru = $isBaru;
    }

    public function build()
    {
        return $this->subject('Nota Transaksi')
                    ->view('emails.transaksi');
    }
}