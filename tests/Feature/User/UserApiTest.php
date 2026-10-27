<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_users_can_be_listed_as_json(): void
    {
        User::factory()->count(2)->create();

        $this->getJson('/api/users')
            ->assertOk()
            ->assertJsonCount(2)
            ->assertJsonStructure([
                '*' => ['id', 'name', 'email', 'created_at', 'updated_at'],
            ]);
    }

    public function test_user_can_be_created(): void
    {
        $response = $this->postJson('/api/users', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);

        $response
            ->assertCreated()
            ->assertJsonPath('data.name', 'Test User')
            ->assertJsonPath('data.email', 'test@example.com')
            ->assertJsonMissingPath('data.password');

        $this->assertDatabaseHas('users', [
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
        $this->assertTrue(Hash::check('password123', User::query()->where('email', 'test@example.com')->value('password')));
    }

    public function test_user_creation_requires_valid_data(): void
    {
        $this->postJson('/api/users', [
            'email' => 'not-an-email',
            'password' => 'short',
        ])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['name', 'email', 'password']);
    }

    public function test_user_can_be_retrieved_as_json(): void
    {
        $user = User::factory()->create();

        $this->getJson("/api/users/{$user->id}")
            ->assertOk()
            ->assertJsonPath('data.id', $user->id)
            ->assertJsonPath('data.email', $user->email)
            ->assertJsonMissingPath('data.password');
    }

    public function test_user_can_be_updated(): void
    {
        $user = User::factory()->create();

        $this->patchJson("/api/users/{$user->id}", ['name' => 'Updated User'])
            ->assertOk()
            ->assertJsonPath('data.name', 'Updated User');

        $this->assertSame('Updated User', $user->fresh()->name);
    }

    public function test_user_update_validates_supplied_data(): void
    {
        $user = User::factory()->create();

        $this->patchJson("/api/users/{$user->id}", [
            'email' => 'not-an-email',
            'password' => 'short',
        ])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['email', 'password']);
    }

    public function test_user_can_be_deleted(): void
    {
        $user = User::factory()->create();

        $this->deleteJson("/api/users/{$user->id}")
            ->assertNoContent();

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }
}
