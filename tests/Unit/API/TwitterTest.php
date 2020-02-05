<?php

namespace Tests\Unit\API;

use App\API\Contracts\TwitterServiceContract;
use Tests\TestCase;

class TwitterTest extends TestCase
{
    /** @test */
    public function itGetsUsersTweets()
    {
        $twitter = resolve(TwitterServiceContract::class);
        $response = $twitter->getTweetsByUser('j7mbo');
        $response = array_shift($response);

        $this->assertArrayHasKey('id', $response);
        $this->assertArrayHasKey('text', $response);
        $this->assertArrayHasKey('user', $response);
        $this->assertArrayHasKey('created_at', $response);
    }
}
