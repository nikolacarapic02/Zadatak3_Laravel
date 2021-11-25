<?php

namespace Tests\Feature;

use App\Models\Assignment;
use App\Models\Group;
use App\Models\Intern;
use Tests\TestCase;
use App\Models\User;
use App\Models\Mentor;
use App\Models\Review;
use Laravel\Passport\Passport;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MentorControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_view_mentor()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create();

        $mentors = Mentor::factory()->count(5)->create();

        Passport::actingAs($user);

        $response = $this->get('/mentors');

        $response->assertStatus(200);
    }

    public function test_can_update_mentor()
    {
        $this->withoutExceptionHandling();

        $authUser = User::factory()->create();

        $mentor = Mentor::factory()->create();

        $user = User::factory()->create([
            'name' => $mentor->name,
            'email' => $mentor->email
        ]);

        Passport::actingAs($authUser);

        $response = $this->json('PUT', "/mentors/{$mentor->id}", [
            'name' => 'John Doe',
            'email' => 'johndoe@gmail.com'
        ]);

        $response->assertStatus(200);
    }

    public function test_can_mentor_create_assignment()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create([
            'role' => User::MENTOR_USER
        ]);

        $mentor = Mentor::factory()->create([
            'name' => $user->name,
            'email' => $user->email,
        ]);

        Passport::actingAs($user);

        $group = Group::factory()->create();

        $mentor->groups()->attach($group->id);

        $response = $this->json('POST',"/mentors/{$mentor->id}/assignments", [
            'title' => 'test',
            'details' => 'This is test!!',
            'group_id' => $group->id
        ]);

        $response->assertStatus(201);
    }

    public function test_can_mentor_update_assignment()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create([
            'role' => User::MENTOR_USER
        ]);

        $mentor = Mentor::factory()->create([
            'name' => $user->name,
            'email' => $user->email
        ]);

        Passport::actingAs($user);

        $group = Group::factory()->create();

        $mentor->groups()->attach($group->id);

        $assignment = Assignment::factory()->create([
            'mentor_id' => $mentor->id,
            'group_id' => $group->id
        ]);

        $response = $this->put("/mentors/{$mentor->id}/assignments/{$assignment->id}", [
            'title' => 'test',
            'details' => 'This is test!!'
        ]);

        $response->assertStatus(200);
    }

    public function test_can_mentor_delete_assignment()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create([
            'role' => User::MENTOR_USER
        ]);

        $mentor = Mentor::factory()->create([
            'name' => $user->name,
            'email' => $user->email
        ]);

        Passport::actingAs($user);

        $group = Group::factory()->create();

        $mentor->groups()->attach($group->id);

        $assignment = Assignment::factory()->create([
            'mentor_id' => $mentor->id,
            'group_id' => $group->id
        ]);

        $response = $this->delete("mentors/{$mentor->id}/assignments/{$assignment->id}");

        $response->assertStatus(200);
    }

    public function test_can_mentor_clone_assignment()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create([
            'role' => User::MENTOR_USER
        ]);

        $mentor = Mentor::factory()->create([
            'name' => $user->name,
            'email' => $user->email
        ]);

        Passport::actingAs($user);

        $group1 = Group::factory()->create();

        $group2 = Group::factory()->create();

        $mentor->groups()->attach($group1->id);
        $mentor->groups()->attach($group2->id);

        $assignment = Assignment::factory()->create([
            'mentor_id' => $mentor->id,
            'group_id' => $group1->id
        ]);

        $response = $this->get("/mentors/{$mentor->id}/assignments/{$assignment->id}/groups/{$group2->id}/clone");

        $response->assertStatus(200);
    }

    public function test_can_mentor_create_review()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create();

        $mentor = Mentor::factory()->create([
            'name' => $user->name,
            'email' => $user->email
        ]);

        Passport::actingAs($user);

        $group = Group::factory()->create();

        $mentor->groups()->attach($group->id);

        $assignment = Assignment::factory()->create([
            'mentor_id' => $mentor->id,
            'group_id' => $group->id,
            'status' => Assignment::ACTIVE_ASSIGNMENT
        ]);


        $intern = Intern::factory()->create([
            'group_id' => $group->id
        ]);

        $response = $this->json('POST', "/mentors/{$mentor->id}/interns/{$intern->id}/reviews",[
            'advantages' => 'test',
            'disadvantages' => 'test',
            'assignment_id' => $assignment->id
        ]);

        $response->assertStatus(201);
    }

    public function test_can_mentor_update_review()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create();

        $mentor = Mentor::factory()->create([
            'name' => $user->name,
            'email' => $user->email
        ]);

        Passport::actingAs($user);

        $group = Group::factory()->create();

        $mentor->groups()->attach($group->id);

        $assignment = Assignment::factory()->create([
            'mentor_id' => $mentor->id,
            'group_id' => $group->id,
            'status' => Assignment::ACTIVE_ASSIGNMENT
        ]);


        $intern = Intern::factory()->create([
            'group_id' => $group->id
        ]);

        $review = Review::factory()->create([
            'mentor_id' => $mentor->id,
            'intern_id' => $intern->id,
            'assignment_id' => $assignment->id
        ]);

        $response = $this->put("/mentors/{$mentor->id}/interns/{$intern->id}/reviews/{$review->id}",[
            'advantages' => 'test',
            'disadvantages' => 'test'
        ]);

        $response->assertStatus(200);
    }

    public function test_can_mentor_delete_review()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create();

        $mentor = Mentor::factory()->create([
            'name' => $user->name,
            'email' => $user->email
        ]);

        Passport::actingAs($user);

        $group = Group::factory()->create();

        $mentor->groups()->attach($group->id);

        $assignment = Assignment::factory()->create([
            'mentor_id' => $mentor->id,
            'group_id' => $group->id,
            'status' => Assignment::ACTIVE_ASSIGNMENT
        ]);


        $intern = Intern::factory()->create([
            'group_id' => $group->id
        ]);

        $review = Review::factory()->create([
            'mentor_id' => $mentor->id,
            'intern_id' => $intern->id,
            'assignment_id' => $assignment->id
        ]);

        $response = $this->delete("/mentors/{$mentor->id}/interns/{$intern->id}/reviews/{$review->id}");

        $response->assertStatus(200);
    }
}
