<?php
namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Task;
use App\Models\User;

class CommentTest extends TestCase
{
    public function test_user_can_add_comment_to_task()
    {
        $user = User::factory()->create();
        $task = Task::factory()->create();
        $this->actingAs($user, 'sanctum')
            ->postJson("/api/tasks/{$task->id}/comments", ['body' => 'Nice'])->assertStatus(201);
    }
}
