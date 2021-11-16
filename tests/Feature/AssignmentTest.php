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

class AssignmentControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_view_assignments()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create();

        Passport::actingAs($user);

        $mentor = Mentor::factory()->create();

        $group = Group::factory()->create();

        $mentor->groups()->attach($group->id);

        $assignments = Assignment::factory()->count(5)->create([
            'mentor_id' => $mentor->id,
            'group_id' => $group->id
        ]);

        $response = $this->get('/assignments');

        $response->assertStatus(200);
    }
}
