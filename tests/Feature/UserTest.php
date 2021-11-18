<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Laravel\Passport\Passport;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_only_admin_view_users()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create([
            'role' => User::ADMIN_USER
        ]);

        Passport::actingAs($user);

        $response = $this->get('/users');

        $response->assertStatus(200);
    }

    public function test_can_view_me()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create();

        Passport::actingAs($user);

        $response = $this->get('/users/me');

        $response->assertStatus(200);
    }

    public function test_can_create_user()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create();

        Passport::actingAs($user);

        $response = $this->json('POST', '/users', [
                'name' => 'James Doe',
                'email' => 'jamesdoe@gmail.com',
                'password' => 'James1234'
            ]);

        $response->assertStatus(201);
    }

    public function test_can_update_user()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create();

        Passport::actingAs($user);

        $response = $this->json('PUT', "users/{$user->id}", [
            'name' => 'Jane Doe',
            'email' => 'janedoe@gmail.com'
        ]);

        $response->assertStatus(200);
    }

    public function test_can_delete_user()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create();

        Passport::actingAs($user);

        $response = $this->delete("users/{$user->id}");

        $response->assertStatus(200);
    }

    public function test_can_verify_user()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create();

        Passport::actingAs($user);

        $response = $this->get("users/verify/{$user->verification_token}");

        $response->assertStatus(200);
    }

    public function test_user_duplication()
    {
        $this->withoutExceptionHandling();

        $user1 = User::factory()->create([
            'name' => 'John Doe',
            'email' => 'johndoe@gmail.com',
            'password' => 'John1234'
        ]);

        $user2 = User::factory()->create([
            'name' => 'John Doe',
            'email' => 'johndoe@gmail.com',
            'password' => 'John1234'
        ]);

        $this->assertTrue($user1 != $user2);
    }
}
