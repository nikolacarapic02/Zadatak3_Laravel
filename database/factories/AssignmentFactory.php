<?php

namespace Database\Factories;

use App\Models\Group;
use App\Models\Mentor;
use App\Models\Assignment;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class AssignmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Assignment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word(),
            'description' => $this->faker->paragraph(2),
            'status' => $status = $this->faker->randomElement([Assignment::ACTIVE_ASSIGNMENT, Assignment::INACTIVE_ASSIGNMENT]),
            'start_date' => $status == Assignment::ACTIVE_ASSIGNMENT ? Carbon::now() : null,
            'finish_date' => $status == Assignment::ACTIVE_ASSIGNMENT ? Carbon::now()->addDays(rand(1,10)):null,
            'group_id' => rand(1,Group::count()),
            'mentor_id' => rand(1, Mentor::count())
        ];
    }
}
