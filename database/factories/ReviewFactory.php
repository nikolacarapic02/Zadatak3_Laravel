<?php

namespace Database\Factories;

use App\Models\Assignment;
use App\Models\Intern;
use App\Models\Mentor;
use App\Models\Review;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Review::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'pros' => $this->faker->paragraph(3),
            'cons' => $this->faker->paragraph(2),
            'assignment_id' => Assignment::all()->random()->id,
            'mentor_id' => Mentor::all()->random()->id,
            'intern_id' => Intern::all()->random()->id
        ];
    }
}
