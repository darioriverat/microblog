<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        'App\Events\EntryCreated' => [
            'App\Listeners\SendEntryCreatedNotification',
            'App\Listeners\LogEntryCreated',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        Event::listen('App\Events\EntryUpdated', function($event) {
            $entry = $event->entry;
            Log::info('Entry updated', ['name' => $entry->author->name, 'twitter_user' => $entry->author->twitter_user, 'title' => $entry->title]);
        });
    }
}
