<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class TaskController extends Controller
{
    public function index(Project $project): JsonResponse
    {
        $tasks = $project->tasks()->orderBy('priority')->get();
        if ($tasks) {
            return response()->json(['status' => 200, 'tasks' => $tasks], Response::HTTP_OK);
        } else {
            return response()->json(['status' => 422, 'tasks' => 'No Data Found'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
