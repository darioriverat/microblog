<?php

namespace Tests\Feature\Entries;

use App\Entry;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Concerns\ShowRouteProvider;
use Tests\TestCase;

class ShowEntryTest extends TestCase
{
    use RefreshDatabase;
    use ShowRouteProvider;

    /**
     * @test
     * @dataProvider showRoutes
     * @param callable $route
     */
    public function anyUserCanAccessToEntryDetails(callable $route)
    {
        $user = factory(User::class)->create();
        $entry = factory(Entry::class)->create(['created_by' => $user->id]);

        $response = $this->get($route($entry));

        $response->assertOk();
    }

    /**
     * @test
     * @dataProvider showRoutes
     * @param callable $route
     */
    public function entryViewHasEntryFields(callable $route)
    {
        $user = factory(User::class)->create();
        $entry = factory(Entry::class)->create(['created_by' => $user->id]);

        $response = $this->get($route($entry));

        $response->assertSeeText($entry->title);
        $response->assertSeeText($entry->description);
        $response->assertSeeText($entry->author->name);
    }

    /**
     * @test
     * @dataProvider showRoutes
     * @param callable $route
     */
    public function entryViewHasEntryEditLinkForAuthor(callable $route)
    {
        $user = factory(User::class)->create();
        $entry = factory(Entry::class)->create(['created_by' => $user->id]);

        $response = $this->actingAs($user)->get($route($entry));

        $response->assertSee(route('admin.entries.edit', $entry->id));
    }

    /**
     * @test
     * @dataProvider showRoutes
     * @param callable $route
     */
    public function entryViewHasNoEntryEditLinkForNonAuthor(callable $route)
    {
        $user = factory(User::class)->create();
        $entry = factory(Entry::class)->create(['created_by' => $user->id]);
        $user2 = factory(User::class)->create();

        $response = $this->actingAs($user2)->get($route($entry));

        $response->assertDontSee(route('admin.entries.edit', $entry->id));
    }

    /**
     * @test
     * @dataProvider showRoutes
     * @param callable $route
     */
    public function entryViewHasAuthorLink(callable $route)
    {
        $user = factory(User::class)->create();
        $entry = factory(Entry::class)->create(['created_by' => $user->id]);

        $response = $this->actingAs($user)->get($route($entry));

        $response->assertSee(route('entries.profile', $entry->author->id));
    }

    /** @test */
    public function wrongOrNonExistingFriendlyUrlCausesNotFoundResponse()
    {
        $user = factory(User::class)->create();
        $entry = factory(Entry::class)->create(['created_by' => $user->id]);

        $response = $this->get(route('entries.showBySlug', [$user->id, $entry->friendly_url . '-url-string-added']));

        $response->assertNotFound();
    }
}
