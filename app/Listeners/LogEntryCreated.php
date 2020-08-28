<?php

namespace App\Listeners;

use App\Events\EntryCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class LogEntryCreated
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

        Log::info('Entry created', ['name' => $entry->author->name, 'twitter_user' => $entry->author->twitter_user, 'title' => $entry->title]);
    }
}
