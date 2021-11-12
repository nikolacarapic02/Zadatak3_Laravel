<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Mentor;
use Laravel\Passport\Passport;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MentorControllerTest extends TestCase
{
    use RefreshDatabase;

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

        if($authUser->isAdmin() || $authUser->isRecruiter())
        {
            $response = $this->json('PUT', "/mentors/{$mentor->id}", [
                'name' => 'John Doe',
                'email' => 'johndoe@gmail.com'
            ]);

            $response->assertStatus(200);
        }
        else
        {
            $response = $this->json('PUT', "/mentors/{$mentor->id}", [
                'name' => 'John Doe',
                'email' => 'johndoe@gmail.com'
            ]);

            $response->assertStatus(403);
        }
    }
}
