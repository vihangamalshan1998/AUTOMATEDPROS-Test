<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        try {
            $status   = $request->query('status');
            $q        = $request->query('q');
            $page     = $request->query('page', 1);
            $cacheKey = 'projects:list:' . md5($status . $q . $page);

            $projects = Cache::remember($cacheKey, 60, function () use ($q, $status) {
                $query = Project::withCount('tasks');

                if ($q) {
                    $query->where('title', 'like', "%{$q}%");
                }

                if ($status) {
                    $query->where('status', $status);
                }

                return $query->paginate(15);
            });

            return response()->json(['success' => true, 'data' => $projects]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch projects',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'title'       => 'required|string',
                'description' => 'nullable|string',
                'start_date'  => 'nullable|date',
                'end_date'    => 'nullable|date',
            ]);

            $data['created_by'] = $request->user()->id;

            $project = Project::create($data);

            // Clear cache if using a list cache
            Cache::forget('projects:list');

            return response()->json(['success' => true, 'data' => $project], 201);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create project',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $project = Project::with('tasks.comments.user', 'tasks.assignedUser', 'creator')
                ->findOrFail($id);

            return response()->json([
                'success' => true,
                'data'    => $project,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch project details',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $data = $request->validate([
                'title'       => 'sometimes|required|string',
                'description' => 'nullable|string',
                'start_date'  => 'nullable|date',
                'end_date'    => 'nullable|date',
            ]);

            $project = Project::findOrFail($id);
            $project->update($data);

                            // Clear cached lists
            Cache::flush(); // clears all cache, or you can forget specific keys if structured

            return response()->json([
                'success' => true,
                'data'    => $project,
                'message' => 'Project updated successfully',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update project',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $project = Project::findOrFail($id);
            $project->delete();

            // Clear cache for project listings
            Cache::forget('projects:list');

            return response()->json([
                'success' => true,
                'message' => 'Project deleted successfully',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete project',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

}
