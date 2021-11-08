<?php

namespace Database\Seeders;

use App\Models\Assignment;
use App\Models\Group;
use App\Models\Intern;
use App\Models\Mentor;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use function GuzzleHttp\Promise\each;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        Group::truncate();
        Mentor::truncate();
        Intern::truncate();
        Assignment::truncate();
        Review::truncate();
        User::truncate();

        Group::flushEventListeners();
        Mentor::flushEventListeners();
        Intern::flushEventListeners();
        Assignment::flushEventListeners();
        Review::flushEventListeners();
        User::flushEventListeners();

        $groupsQuantity = 15;
        $mentorsQuantity = 30;
        $userQuantity = 5;

        User::factory()->count($userQuantity)->create();
        Group::factory()->count($groupsQuantity)->create();
        Mentor::factory()->count($mentorsQuantity)->create()->each(
            function($mentor)
            {
                $groups = Group::all()->random(mt_rand(1,2))->pluck('id');

                $mentor->groups()->attach($groups);

                User::factory()->create(
                    [
                        'name' => $mentor->name,
                        'email' => $mentor->email,
                        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password,
                        'role' => User::MENTOR_USER,
                        'verified' => User::UNVERIFIED_USER,
                        'verification_token' => User::generateVerificationToken()
                    ]
                );

                Intern::factory()->count(rand(2,4))->create(
                    [
                        'group_id' => $groups->first()
                    ]
                );
                Assignment::factory()->count(rand(1,3))->create(
                    [
                        'group_id' => $groups->first(),
                        'mentor_id' => $mentor->id
                    ]
                );

                $intern = $mentor->interns;
                $assignment = $mentor->assignments;

                Review::factory()->count(rand(0,2))->create(
                    [
                        'assignment_id' => $assignment->first(),
                        'mentor_id' => $mentor->id,
                        'intern_id' => $intern->first()
                    ]
                );
            });
    }
}
