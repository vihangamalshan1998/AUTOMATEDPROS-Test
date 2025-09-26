<?php
namespace App\Services;

use App\Models\Task;
use App\Models\User;
use App\Notifications\TaskAssigned;
use Illuminate\Validation\ValidationException;

class TaskAssignmentService
{
    public function assign(Task $task, int $userId, $assigner)
    {
        $user = User::find($userId);
        if (! $user) {
            throw ValidationException::withMessages(['assigned_to' => 'User not found']);
        }

        if ($task->status === Task::STATUS_DONE) {
            throw ValidationException::withMessages(['task' => 'Completed tasks cannot be reassigned']);
        }

        // assign & persist
        $task->assigned_to = $userId;
        $task->save();

        // notify assigned user (notification implements ShouldQueue - queued)
        $user->notify(new TaskAssigned($task, $assigner));

        return $task;
    }
}
