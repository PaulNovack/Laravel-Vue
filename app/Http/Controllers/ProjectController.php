<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ProjectController extends Controller
{
    public function index(): JsonResponse
    {
        $projects = Project::all();
        if ($projects->isNotEmpty()) {
            return response()->json(['status' => 200, 'projects' => $projects], Response::HTTP_OK);
        } else {
            return response()->json(['status' => 200, 'projects' => 'No Data Found'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
