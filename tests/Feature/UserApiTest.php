<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test the index endpoint to fetch paginated users.
     */
    public function test_index_returns_paginated_users()
    {
        User::factory()->count(15)->create();

        $response = $this->getJson('/api/users');

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'name', 'ip', 'comment', 'created_at', 'updated_at']
                ],
                'links',
            ]);
    }

    /**
     * Test the show endpoint to fetch a specific user.
     */
    public function test_show_returns_user_data()
    {
        $user = User::factory()->create();

        $response = $this->getJson("/api/users/{$user->id}");

        $response
            ->assertStatus(200)
            ->assertJson(["id" => $user->id, "name" => $user->name]);
    }

    /**
     * Test the store endpoint to create a new user.
     */
    public function test_store_creates_new_user()
    {
        $data = [
            'name' => 'John Doe',
            'password' => 'securepassword',
            'email' => 'john@gmail.com',
            'ip' => '192.168.1.1',
            'comment' => 'A test user',
        ];

        $response = $this->postJson('/api/users', $data);

        $response
            ->assertStatus(201)
            ->assertJson(["name" => $data['name']]);

        $this->assertDatabaseHas('users', ["name" => $data['name'], "ip" => $data['ip']]);
    }

    /**
     * Test the update endpoint to update a user's information.
     */
    public function test_update_modifies_user_data()
    {
        $user = User::factory()->create();
        $updatedData = [
            'name' => 'Jane Doe',
            'password' => 'newpassword',
            'ip' => '192.168.1.100',
            'comment' => 'Updated comment',
        ];

        $response = $this->putJson("/api/users/{$user->id}", $updatedData);

        $response
            ->assertStatus(200)
            ->assertJson(["name" => $updatedData['name']]);

        $this->assertDatabaseHas('users', ["name" => $updatedData['name'], "ip" => $updatedData['ip']]);
    }

    /**
     * Test the destroy endpoint to delete a user.
     */
    public function test_destroy_deletes_user()
    {
        $user = User::factory()->create();

        $response = $this->deleteJson("/api/users/{$user->id}");

        $response
            ->assertStatus(200)
            ->assertJson(["message" => "Пользователь успешно удалён."]);

        $this->assertDatabaseMissing('users', ["id" => $user->id]);
    }

    /**
     * Test validation for creating a user.
     */
    public function test_store_validates_input()
    {
        $invalidData = [
            'name' => '',
            'password' => '',
            'ip' => 'invalid-ip',
        ];

        $response = $this->postJson('/api/users', $invalidData);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'password', 'ip']);
    }

    /**
     * Test validation for updating a user.
     */
    public function test_update_validates_input()
    {
        $user = User::factory()->create();

        $invalidData = [
            'name' => '',
            'ip' => 'invalid-ip',
        ];

        $response = $this->putJson("/api/users/{$user->id}", $invalidData);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'ip']);
    }
}
