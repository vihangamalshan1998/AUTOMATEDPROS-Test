<?php
namespace App\Notifications;

use App\Models\Task; // ✅ correct import
use App\Models\User; // (optional if you want to type-hint assigner)
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TaskAssigned extends Notification implements ShouldQueue
{
    use Queueable;

    protected $task;
    protected $assigner;

    public function __construct(Task $task, $assigner)
    {
        $this->task     = $task;
        $this->assigner = $assigner;
    }

    public function via($notifiable)
    {
        return ['mail', 'database']; // example channels
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('New Task Assigned')
            ->line("A new task has been assigned to you: {$this->task->title}")
            ->line("Assigned by: {$this->assigner->name}")
            ->action('View Task', url("/tasks/{$this->task->id}"))
            ->line('Please complete it before the due date.');
    }

    public function toArray($notifiable)
    {
        return [
            'task_id'       => $this->task->id,
            'task'          => $this->task->title,
            'assigner'      => $this->assigner->id ?? null,
            'assigner_name' => $this->assigner->name ?? null,
        ];
    }
}
