<?php

namespace Tests\Feature\Entries;

use App\Entry;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShowEntryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function anyUserCanAccessToEntryDetails()
    {
        $user = factory(User::class)->create();
        $entry = factory(Entry::class)->create(['created_by' => $user->id]);

        $response = $this->get(route('entries.show', $entry));

        $response->assertOk();
    }

    /** @test */
    public function entryViewHasEntryFields()
    {
        $user = factory(User::class)->create();
        $entry = factory(Entry::class)->create(['created_by' => $user->id]);

        $response = $this->get(route('entries.show', $entry));

        $response->assertSeeText($entry->title);
        $response->assertSeeText($entry->description);
        $response->assertSeeText($entry->author->name);
    }

    /** @test */
    public function entryViewHasEntryEditLinkForAuthor()
    {
        $user = factory(User::class)->create();
        $entry = factory(Entry::class)->create(['created_by' => $user->id]);

        $response = $this->actingAs($user)->get(route('entries.show', $entry));

        $response->assertSee(route('admin.entries.edit', $entry->id));
    }

    /** @test */
    public function entryViewHasNoEntryEditLinkForNonAuthor()
    {
        $user = factory(User::class)->create();
        $entry = factory(Entry::class)->create(['created_by' => $user->id]);
        $user2 = factory(User::class)->create();

        $response = $this->actingAs($user2)->get(route('entries.show', $entry));

        $response->assertDontSee(route('admin.entries.edit', $entry->id));
    }

    /** @test */
    public function entryViewHasAuthorLink()
    {
        $user = factory(User::class)->create();
        $entry = factory(Entry::class)->create(['created_by' => $user->id]);

        $response = $this->actingAs($user)->get(route('entries.show', $entry));

        $response->assertSee(route('entries.profile', $entry->author->id));
    }
}
