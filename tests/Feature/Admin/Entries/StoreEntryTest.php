<?php

namespace Tests\Feature\Admin\Entries;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Concerns\WrongStoreEntryDataProvider;
use Tests\TestCase;

class StoreEntryTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;
    use WrongStoreEntryDataProvider;

    /** @test */
    public function anAuthorizedUserCanStoreAnEntry()
    {
        $user = factory(User::class)->create();

        $title = $this->faker->text(50);

        $entry = [
            'title' => $title,
            'friendly_url' => preg_replace(['#\s#', '#\.#'], '-', $title),
            'description' => $this->faker->text(100),
            'content' => $this->faker->text,
        ];

        $response = $this->actingAs($user)->post(route('admin.entries.store'), $entry);

        $this->assertDatabaseHas(
            'entries',
            $entry
        );

        $response->assertSessionHas('success');
    }

    /** @test */
    public function anUnauthorizedUserCannotStoreAnEntry()
    {
        $title = $this->faker->realText(20);

        $entry = [
            'title' => $title,
            'friendly_url' => str_replace(' ', '-', $title),
            'description' => $this->faker->text(100),
            'content' => $this->faker->text,
        ];

        $response = $this->post(route('admin.entries.store'), $entry);

        $response->assertRedirect(route('login'));
    }

    /**
     * @test
     * @dataProvider wrongEntryData
     * @param callable $field
     * @param string $fieldName
     */
    public function anEntryCannotBeStoredDueToValidationErrors(callable $field, string $fieldName)
    {
        $user = factory(User::class)->create();

        $title = $this->faker->text(350);

        $entry = [
            'title' => $title,
            'friendly_url' => preg_replace(['#\s#', '#\.#'], '-', $title),
            'description' => $this->faker->text(100),
            'content' => $this->faker->text,
        ];

        $entry = array_replace_recursive($entry, [$fieldName => $field($this->faker)]);

        $response = $this->actingAs($user)->post(route('admin.entries.store'), $entry);

        $response->assertSessionHasErrors($fieldName);
    }
}
