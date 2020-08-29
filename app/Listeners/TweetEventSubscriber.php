<?php

namespace App\Listeners;

use App\Events\TweetHidden;
use App\Events\TweetShowed;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class TweetEventSubscriber
{
    public function handleHiddenTweet($event)
    {
        Log::info('Tweet hidden', ['tweet' => $event->id]);
    }

    public function handleShowedTweet($event)
    {
        Log::info('Tweet showed', ['tweet' => $event->id]);
    }

    public function subscribe($dispatcher)
    {
        $dispatcher->listen(
            TweetHidden::class,
            'App\Listeners\TweetEventSubscriber@handleHiddenTweet'
        );

        $dispatcher->listen(
            TweetShowed::class,
            'App\Listeners\TweetEventSubscriber@handleShowedTweet'
        );
    }
}
