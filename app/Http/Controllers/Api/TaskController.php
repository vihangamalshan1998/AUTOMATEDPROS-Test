<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Task;
use App\Services\TaskAssignmentService;
use Exception;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index($project_id)
    {
        try {
            $project = Project::findOrFail($project_id);
            $tasks   = $project->tasks()->paginate(15);

            return response()->json([
                'success' => true,
                'data'    => $tasks,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch tasks',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $task = Task::findOrFail($id);

            return response()->json([
                'success' => true,
                'data'    => $task,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Task not found',
                'error'   => $e->getMessage(),
            ], 404);
        }
    }

    public function store(Request $request, $project_id, TaskAssignmentService $assignService)
    {
        try {
            $project = Project::findOrFail($project_id);

            $data = $request->validate([
                'title'       => 'required|string',
                'description' => 'nullable|string',
                'due_date'    => 'nullable|date',
                'assigned_to' => 'nullable|exists:users,id',
            ]);

            $data['project_id'] = $project->id;
            $task               = Task::create($data);

            if (! empty($data['assigned_to'])) {
                $assignService->assign($task, $data['assigned_to'], $request->user());
            }

            return response()->json(['success' => true, 'data' => $task], 201);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create task',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $task = Task::findOrFail($id);

            $task->update($request->only([
                'title',
                'description',
                'status',
                'due_date',
                'assigned_to',
            ]));

            return response()->json([
                'success' => true,
                'data'    => $task,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update task',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $task = Task::findOrFail($id);
            $task->delete();

            return response()->json([
                'success' => true,
                'message' => 'Task deleted successfully',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete task',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }
}
