<?php

namespace Tests\Feature;

use App\Models\Assignment;
use App\Models\Group;
use App\Models\Intern;
use App\Models\Mentor;
use App\Models\Review;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Passport;
use Tests\TestCase;

class ReviewControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_view_reviews()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create([
            'role' => User::MENTOR_USER
        ]);

        $group = Group::factory()->create();

        $mentor = Mentor::factory()->create([
            'name' => $user->name,
            'email' => $user->email
        ]);

        $mentor->groups()->attach($group->id);

        $intern = Intern::factory()->create([
            'group_id' => $group->id
        ]);

        $assignment = Assignment::factory()->create([
            'mentor_id' => $mentor->id,
            'group_id' => $group->id
        ]);


        $review = Review::factory()->create([
            'intern_id' => $intern->id,
            'mentor_id' => $mentor->id,
            'assignment_id' => $assignment->id
        ]);

        Passport::actingAs($user);

        $response = $this->get("/reviews/{$review->id}");

        $response->assertStatus(200);
    }
}
