<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectRequest;
use App\Models\Project;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class ProjectController extends Controller
{
    public function index(): JsonResponse
    {
        $projects = Project::orderBy('name')->get();
        if ($projects->isNotEmpty()) {
            return response()->json(['status' => 200, 'projects' => $projects], Response::HTTP_OK);
        } else {
            return response()->json(['status' => 200, 'projects' => 'No Data Found'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    public function store(StoreProjectRequest $request): JsonResponse
    {
        // The validated data is automatically available via the $request->validated() method
        $validated = $request->validated();

        $project = Project::create([
            'name' => $validated['name'],
        ]);

        return response()->json([
            'success' => true,
            'data' => $project,
        ], 201);
    }

    public function delete(Project $project): JsonResponse
    {
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
