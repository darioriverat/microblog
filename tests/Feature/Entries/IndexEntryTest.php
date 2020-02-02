<?php

namespace Tests\Feature\Entries;

use App\Entry;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IndexEntryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function anyUserCanAccessToEntryIndex()
    {
        $user = factory(User::class)->create();
        $entry = factory(Entry::class)->create(['created_by' => $user->id]);

        $response = $this->get(route('entries.index', $entry));

        $response->assertOk();
    }

    /** @test */
    public function entryIndexHasSomeEntryFields()
    {
        $user = factory(User::class)->create();
        $entry = factory(Entry::class)->create(['created_by' => $user->id]);

        $response = $this->get(route('entries.index', $entry));

        $response->assertSeeText($entry->title);
        $response->assertSeeText($entry->author->name);
    }

    /** @test */
    public function entryViewHasEntryEditLinkForAuthor()
    {
        $user = factory(User::class)->create();
        $entry = factory(Entry::class)->create(['created_by' => $user->id]);

        $response = $this->actingAs($user)->get(route('entries.index', $entry));

        $response->assertSee(route('admin.entries.edit', $entry->id));
    }

    /** @test */
    public function entryViewHasNoEntryEditLinkForNonAuthor()
    {
        $user = factory(User::class)->create();
        $entry = factory(Entry::class)->create(['created_by' => $user->id]);
        $user2 = factory(User::class)->create();

        $response = $this->actingAs($user2)->get(route('entries.index', $entry));

        $response->assertDontSee(route('admin.entries.edit', $entry->id));
    }

    /** @test */
    public function entryViewHasAuthorLink()
    {
        $user = factory(User::class)->create();
        $entry = factory(Entry::class)->create(['created_by' => $user->id]);

        $response = $this->actingAs($user)->get(route('entries.index', $entry));

        $response->assertSee(route('entries.profile', $entry->author->id));
    }
}
