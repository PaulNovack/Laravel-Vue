<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectRequest;
use App\Models\Project;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProjectController extends Controller
{
    private UserService $userService;
    private User $user;

    public function __construct(Request $request, UserService $userService)
    {
        $this->userService = $userService;
        $this->user = $this->userService->getCurrentUser($request);
    }

    public function index(): JsonResponse
    {
        // Retrieve only the projects belonging to the authenticated user
        $projects = Project::where('user_id', $this->user->id)->orderBy('name')->get();

        if ($projects->isNotEmpty()) {
            return response()->json(['status' => 200, 'projects' => $projects], Response::HTTP_OK);
        } else {
            return response()->json(['status' => 204, 'projects' => 'No Data Found'], Response::HTTP_NO_CONTENT);
        }
    }

    public function store(StoreProjectRequest $request): JsonResponse
    {
        $validated = $request->validated();

        // Create a project under the authenticated user
        $project = Project::create([
            'name' => $validated['name'],
            'user_id' => $this->user->id,
        ]);

        return response()->json([
            'success' => true,
            'data' => $project,
        ], 201);
    }

    public function delete(Project $project): JsonResponse
    {
        // Ensure the project belongs to the authenticated user
        if ($project->user_id !== $this->user->id) {
            return response()->json([
                'message' => 'Unauthorized access to delete this project.',
            ], 403);
        }

        try {
            $project->tasks()->delete();
            $project->delete();

            return response()->json([
                'message' => 'Project deleted successfully.',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to delete the Project.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
