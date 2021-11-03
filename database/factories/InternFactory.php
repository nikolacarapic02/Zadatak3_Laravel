<?php

namespace Database\Factories;

use App\Models\Group;
use App\Models\Intern;
use App\Models\Mentor;
use Illuminate\Database\Eloquent\Factories\Factory;

class InternFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Intern::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'city' => $this->faker->city,
            'address' => $this->faker->address,
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'cv' => $this->faker->randomElement(['cv1.txt', 'cv2.txt', 'cv3.txt']),
            'github' => 'https://github.com/'.$this->faker->userName(),
            'group_id' => Group::all()->random()->id
        ];
    }
}
