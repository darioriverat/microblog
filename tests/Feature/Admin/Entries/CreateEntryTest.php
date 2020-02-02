<?php

namespace Tests\Feature\Admin\Entries;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateEntryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function anAuthorizedUserCanAccessToTheCreationView()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)
            ->get(route('admin.entries.create'));

        $response->assertOk();
    }

    /** @test */
    public function anUnauthorizedUserCannotAccessToTheCreationView()
    {
        $response = $this->get(route('admin.entries.create'));

        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function entryFormHasEntryFieldsAndSubmitButton()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)
            ->get(route('admin.entries.create'));

        $response->assertSeeText('Title');
        $response->assertSeeText('Friendly url');
        $response->assertSeeText('Description');
        $response->assertSeeText('Content');
        $response->assertSeeText('Save');
    }
}
