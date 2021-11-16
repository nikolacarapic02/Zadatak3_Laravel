<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Group;
use App\Models\Intern;
use Laravel\Passport\Passport;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InternControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_view_intern()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create();

        $group = Group::factory()->create();

        $interns = Intern::factory()->count(5)->create([
            'group_id' => $group->id
        ]);

        Passport::actingAs($user);

        $response = $this->get('interns');

        $response->assertStatus(200);
    }

    public function test_can_create_intern()
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
            'CV' => UploadedFile::fake()->create('cv.pdf', 2000000),
            'GitHub' => 'johnDoe',
            'group_id' => $group->id
        ]);

        $response->assertStatus(201);

        $intern = Intern::all()->first();

        Storage::delete($intern->cv);
    }

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
