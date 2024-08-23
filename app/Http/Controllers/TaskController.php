<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderTasksRequest;
use App\Http\Requests\StoreTaskRequest;
use App\Models\Project;
use App\Models\Task;
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

    public function store(StoreTaskRequest $request, $task = null): JsonResponse
    {
        $validated = $request->validated();

        if ($task) {
            $task = Task::findOrFail($task);
            $task->update([
                'name' => $validated['name'],
                'project_id' => $validated['project_id'],
            ]);
        } else {
            $task = Task::create([
                'name' => $validated['name'],
                'project_id' => $validated['project_id'],
                'priority' => Task::where('project_id', $validated['project_id'])->max('priority') + 1,
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => $task,
        ], $task ? 200 : 201);
    }

    public function delete(Task $task): JsonResponse
    {
        try {
            $task->delete();

            return response()->json([
                'message' => 'Task deleted successfully.',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to delete the task.',
                'error' => $e->getMessage(),
            ], 500);
        }

    }

    public function order(OrderTasksRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $priority = 1;
        foreach ($validated['tasks'] as $taskData) {
            Task::where('id', $taskData['id'])->update(['priority' => $priority++]);
        }

        return response()->json(['success' => true, 'message' => 'Task order updated successfully.']);
    }
}
