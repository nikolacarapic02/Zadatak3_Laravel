<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Group;
use App\Models\Intern;
use Laravel\Passport\Passport;
use Illuminate\Support\Facades\File;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;

class InternControllerTest extends TestCase
{
    use RefreshDatabase;

    /*public function test_can_create_intern()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create();

        $group = Group::factory()->create();

        Passport::actingAs($user);


        $response = $this->json('POST', '/interns', [
            'name' => 'John Doe',
            'city' => 'London',
            'address' => 'Trafalgar 12',
            'email' => 'johndoe12@gmail.com',
            'mobile_phone' => '090370813294',
            'CV' => Storage::disk('local')->put('/public/cv/cv.txt', 'John Doe'),
            'GitHub' => 'johnDoe',
            'group_id' => $group->id
        ]);

        $response->assertStatus(201);
    }*/

    public function test_can_update_intern()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create();

        $group = Group::factory()->create();

        $intern = Intern::factory()->create([
            'group_id' => $group->id
        ]);

        Passport::actingAs($user);

        $response = $this->json('PUT', "/interns/{$intern->id}", [
            'name' => 'Jane Doe',
        ]);

        $response->assertStatus(200);
    }

    public function test_can_delete_intern()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create();

        $group = Group::factory()->create();

        $intern = Intern::factory()->create([
            'group_id' => $group->id
        ]);

        Passport::actingAs($user);

        $response = $this->delete("/interns/{$intern->id}");

        $response->assertStatus(200);
    }
}
