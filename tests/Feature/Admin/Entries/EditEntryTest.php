<?php

namespace Tests\Feature\Admin\Entries;

use App\Entry;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EditEntryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function anAuthorizedUserCanAccessToTheEditionView()
    {
        $user = factory(User::class)->create();
        $entry = factory(Entry::class)->create(['created_by' => $user->id]);

        $response = $this->actingAs($user)->get(route('admin.entries.edit', $entry));

        $response->assertOk();
    }

    /** @test */
    public function anAuthorizedUserCannotAccessToTheEditionView()
    {
        $user = factory(User::class)->create();
        $entry = factory(Entry::class)->create(['created_by' => $user->id]);

        $response = $this->get(route('admin.entries.edit', $entry));

        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function entryFormHasEntryFieldsAndSubmitButton()
    {
        $user = factory(User::class)->create();
        $entry = factory(Entry::class)->create(['created_by' => $user->id]);

        $response = $this->actingAs($user)
            ->get(route('admin.entries.edit', $entry));

        $response->assertSeeText('Title');
        $response->assertSeeText('Description');
        $response->assertSeeText('Content');
        $response->assertSeeText('Save');
    }
}
