<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Task;
use Exception;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, $task_id)
    {
        try {
            $request->validate([
                'body' => 'required|string',
            ]);

            $task = Task::findOrFail($task_id);

            $comment = Comment::create([
                'body'    => $request->body,
                'task_id' => $task->id,
                'user_id' => $request->user()->id,
            ]);

            return response()->json([
                'success' => true,
                'data'    => $comment,
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to add comment',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    public function index($task_id)
    {
        try {
            $task = Task::findOrFail($task_id);

            $comments = Comment::with('user:id,name,email') // eager load user
                ->where('task_id', $task->id)
                ->latest()
                ->get();

            return response()->json([
                'success' => true,
                'data'    => $comments,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch comments',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }
}
