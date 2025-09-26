<?php
namespace Tests\Unit;

use App\Models\Task;
use App\Models\User;
use App\Services\TaskAssignmentService; // <- Laravel's TestCase
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskAssignmentServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_assign_throws_when_user_missing()
    {
        $this->expectException(\Illuminate\Validation\ValidationException::class);

        $service = new TaskAssignmentService();
        $task    = Task::factory()->create();

        // Try assigning non-existing user
        $service->assign($task, 999999, User::factory()->create());
    }
}
