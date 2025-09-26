<?php
namespace Tests\Feature;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Tests\TestCase;

class TaskTest extends TestCase
{
    /**
     * A basic Feature test example.
     */
    public function test_manager_can_update_task()
    {
        $manager = User::factory()->create(['role' => 'manager']);
        $project = Project::factory()->create(['created_by' => User::factory()->create(['role' => 'admin'])->id]);
        $task    = Task::factory()->create(['project_id' => $project->id]);

        $this->actingAs($manager, 'sanctum')
            ->putJson("/api/tasks/{$task->id}", ['title' => 'Updated'])->assertStatus(200);
    }

}
