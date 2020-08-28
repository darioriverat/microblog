<?php

namespace App\Providers;

use App\API\Contracts\TwitterServiceContract;
use App\Services\TwitterService;
use Illuminate\Support\ServiceProvider;
use Tests\Mocks\TwitterServiceMock;

class TwitterServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(TwitterServiceContract::class, function ($app, array $params) {
            if (config('app.env') == 'testing') {
                return new TwitterServiceMock;
            } else {
                $twitter = new TwitterService();
                $twitter->setConsumerKey(config('twitter.api_key'));
                $twitter->setSecretKey(config('twitter.api_secret_key'));

                return $twitter;
            }
        });
    }
}
