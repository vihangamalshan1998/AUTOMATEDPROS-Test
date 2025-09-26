<?php
namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title'       => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(),
            'start_date'  => $this->faker->date(),
            'end_date'    => $this->faker->date(),
            'created_by'  => User::inRandomOrder()->first()?->id ?? User::factory(),
        ];
    }
}
