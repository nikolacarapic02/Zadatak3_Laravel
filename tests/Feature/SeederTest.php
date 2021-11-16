<?php

namespace Tests\Feature;

use App\Models\Assignment;
use Tests\TestCase;
use App\Models\User;
use App\Models\Group;
use App\Models\Intern;
use App\Models\Mentor;
use App\Models\Review;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SeederTest extends TestCase
{
    public function test_if_seeder_work()
    {
        $this->seed();

        $this->assertTrue(User::all()->isNotEmpty() || Mentor::all()->isNotEmpty() || Intern::all()->isNotEmpty() || Group::all()->isNotEmpty() || Assignment::all()->isNotEmpty() || Review::all()->isNotEmpty());
    }
}
