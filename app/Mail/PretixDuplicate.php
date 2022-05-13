<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PretixDuplicate extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $email;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($order, $email)
    {
        $this->order = $order;
        $this->email = $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.pretix.duplicate')
                    ->subject('Doppelte E-Mail Adresse');
    }
}
