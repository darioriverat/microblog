<?php

namespace Tests\Feature\Entries;

use App\Entry;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileEntryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function anyUserCanAccessToUsersProfile()
    {
        $user = factory(User::class)->create();
        $response = $this->get(route('entries.profile', $user->id));

        $response->assertOk();
    }

    /** @test */
    public function profileViewHasEntryList()
    {
        $user = factory(User::class)->create();
        $entry = factory(Entry::class)->create(['created_by' => $user->id]);

        $response = $this->get(route('entries.profile', $user->id));

        $response->assertSeeText($entry->title);
        $response->assertSeeText($entry->author->name);
    }

    /** @test */
    public function profileViewHasNoEntryEditLinkForNonAuthors()
    {
        $user = factory(User::class)->create();
        $entry = factory(Entry::class)->create(['created_by' => $user->id]);
        $user2 = factory(User::class)->create();

        $response = $this->actingAs($user2)->get(route('entries.profile', $user->id));

        $response->assertDontSee(route('admin.entries.edit', $entry->id));
    }

    /** @test */
    public function profileViewHasAuthorLink()
    {
        $user = factory(User::class)->create();
        $entry = factory(Entry::class)->create(['created_by' => $user->id]);

        $response = $this->actingAs($user)->get(route('entries.profile', $user->id));

        $response->assertSee(route('entries.profile', $entry->author->id));
    }

    /** @test */
    public function profileListsUsersTweets()
    {
        $user = factory(User::class)->create();
        $response = $this->get(route('entries.profile', $user->id));

        $response->assertSeeText('Latest tweets');
        $response->assertSeeText('James Mallison');
        $response->assertSeeText('@Femi_Sorry I’m against brexit.');
        $response->assertSeeText('@sylv3on_ I found this too.');
    }

    /** @test */
    public function itNotListsHiddenTweetsToAnyone()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)->json('POST', route('admin.tweets.store'), [
            'tweet_id' => '1223947395387547648',
        ]);

        $this->post(route('logout'));

        $response = $this->get(route('entries.profile', $user->id));

        $response->assertDontSeeText('@Femi_Sorry I’m against brexit.');
    }

    /** @test */
    public function itListsHiddenTweetsToTheOwner()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)->json('POST', route('admin.tweets.store'), [
            'tweet_id' => '1223947395387547648',
        ]);

        $response = $this->get(route('entries.profile', $user->id));

        $response->assertSeeText('@Femi_Sorry I’m against brexit.');
    }
}
