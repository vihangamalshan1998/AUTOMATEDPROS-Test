<?php
namespace App\Jobs;

use App\Models\Task;
use App\Notifications\TaskAssigned;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendTaskAssignedEmail implements ShouldQueue
{
    use Dispatchable, Queueable;
    public $task, $user;

    public function __construct(Task $task, $user)
    {
        $this->task = $task;
        $this->user = $user;
    }

    public function handle()
    {
        $this->user->notify(new TaskAssigned($this->task));
    }
}
