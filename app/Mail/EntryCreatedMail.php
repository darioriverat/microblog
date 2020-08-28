<?php

namespace App\Mail;

use App\Entry;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EntryCreatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $entry;

    /**
     * Create a new message instance.
     *
     * @param Entry $entry
     */
    public function __construct(Entry $entry)
    {
        $this->entry = $entry;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.notification');
    }
}
