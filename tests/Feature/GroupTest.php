<?php

namespace Tests\Feature;

use App\Models\Assignment;
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

    public function test_can_view_group()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create();

        $groups = Group::factory()->count(5)->create();

        Passport::actingAs($user);

        $response = $this->get('/groups');

        $response->assertStatus(200);
    }

    public function test_can_create_group()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create();

        Passport::actingAs($user);

        $response = $this->json('POST', '/groups', [
            'name' => 'London'
            ]);

        $response->assertStatus(201);
    }

    public function test_can_update_group()
    {
        $this->withoutExceptionHandling();

        $group = Group::factory()->create();

        $user = User::factory()->create();

        Passport::actingAs($user);

        $response = $this->json('PUT', "/groups/{$group->id}", [
            'name' => 'Berlin'
        ]);

        $response->assertStatus(200);
    }

    public function test_can_delete_group()
    {
        $this->withoutExceptionHandling();

        $group = Group::factory()->create();

        $user = User::factory()->create();

        Passport::actingAs($user);

        $response = $this->delete("/groups/{$group->id}");

        $response->assertStatus(200);
    }

    public function test_can_activate_assignment_in_group()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create([
            'role' => User::MENTOR_USER
        ]);

        $mentor =Mentor::factory()->create([
            'name' => $user->name,
            'email' => $user->email
        ]);

        Passport::actingAs($user);

        $group = Group::factory()->create();

        $mentor->groups()->attach($group->id);

        $assignment = Assignment::factory()->create([
            'mentor_id' => $mentor->id,
            'group_id' => $group->id,
            'status' => Assignment::INACTIVE_ASSIGNMENT
        ]);

        $response = $this->put("/groups/{$group->id}/assignments/{$assignment->id}/activate", [
            'finishDate' => '2021-11-25'
        ]);

        $response->assertStatus(200);

    }

    public function test_can_add_mentor_in_group()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create();

        Passport::actingAs($user);

        $group = Group::factory()->create();

        $mentor = Mentor::factory()->create();

        $response = $this->put("/groups/{$group->id}/addmentor",[
            'mentor_id' => $mentor->id
        ]);

        $response->assertStatus(200);
    }

    public function test_can_delete_mentor_from_group()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create();

        Passport::actingAs($user);

        $group = Group::factory()->create();

        $mentor = Mentor::factory()->create();

        $response = $this->put("/groups/{$group->id}/addmentor",[
            'mentor_id' => $mentor->id
        ]);

        $response->assertStatus(200);
    }
}
