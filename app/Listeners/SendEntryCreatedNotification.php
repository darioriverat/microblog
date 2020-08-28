<?php

namespace App\Listeners;

use App\Events\EntryCreated;
use App\Mail\EntryCreatedMail;
use App\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendEntryCreatedNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  EntryCreated  $event
     * @return void
     */
    public function handle(EntryCreated $event)
    {
        $entry = $event->entry;

        Mail::to(User::all())->send(new EntryCreatedMail($entry));
    }
}
