<?php

namespace Tests\Feature\Tweets;

use App\HiddenTweets;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StoreTweetsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function aTweetCanBeStoredToHideIt()
    {
        $user = factory(User::class)->create();
        $this->get(route('entries.profile', $user->id));

        $response = $this->actingAs($user)->json('POST', route('admin.tweets.store'), [
            'tweet_id' => '1223947395387547648',
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'created' => true,
            ]);

        $this->assertDatabaseHas('hidden_tweets', [
            'tweet_id' => '1223947395387547648',
        ]);
    }

    /** @test */
    public function aTweetCanBeDeletedToUnHideIt()
    {
        $tweet = factory(HiddenTweets::class)->create();

        $response = $this->actingAs($tweet->user)->json('DELETE', route('admin.tweets.destroy', $tweet->tweet_id), [
            'tweet_id' => $tweet->id,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'deleted' => true,
            ]);

        $this->assertDatabaseMissing('hidden_tweets', [
            'id' => $tweet->id,
        ]);
    }
}
