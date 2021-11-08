<?php

namespace Database\Factories;

use App\Models\Assignment;
use App\Models\Group;
use App\Models\Mentor;
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
            'start_date' => null,
            'finish_date' => null,
            'status' => Assignment::INACTIVE_ASSIGNMENT,
            'group_id' => rand(1,Group::count()),
            'mentor_id' => rand(1, Mentor::count())
        ];
    }
}
