<?php

namespace Tests\Feature;

use App\Models\Group;
use App\Models\Mentor;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;

class GroupControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_group()
    {
        $user = User::factory()->create();

        Passport::actingAs($user);

        if($user->isAdmin() || $user->isRecruiter())
        {
            $response = $this->json('POST', '/groups', [
                'name' => 'London'
            ]);

            $response->assertStatus(201);
        }
    }

    public function test_can_update_group()
    {
        $this->withoutExceptionHandling();

        $group = Group::factory()->create();

        $user = User::factory()->create();

        Passport::actingAs($user);

        if($user->isAdmin() || $user->isRecruiter())
        {
            $response = $this->json('PUT', "/groups/{$group->id}", [
                'name' => 'Berlin'
            ]);

            $response->assertStatus(200);
        }
    }

    public function test_can_delete_group()
    {
        $group = Group::factory()->create();

        $user = User::factory()->create();

        Passport::actingAs($user);

        if($user->isAdmin() || $user->isRecruiter())
        {
            $response = $this->delete("/groups/{$group->id}");

            $response->assertStatus(200);
        }
    }
}
