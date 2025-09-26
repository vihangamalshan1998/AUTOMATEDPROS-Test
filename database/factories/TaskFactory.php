<?php
namespace Database\Factories;

use App\Models\Task;
use App\Models\User;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Task::class;

    public function definition()
    {
        return [
            'title'       => $this->faker->sentence(4),
            'description' => $this->faker->paragraph(),
            'status'      => $this->faker->randomElement(['pending', 'in-progress', 'done']),
            'due_date'    => $this->faker->dateTimeBetween('now', '+1 month'),
            'project_id'  => Project::inRandomOrder()->first()?->id ?? Project::factory(),
            'assigned_to' => User::inRandomOrder()->first()?->id ?? User::factory(),
        ];
    }
}
