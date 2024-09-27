<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderTasksRequest;
use App\Http\Requests\StoreTaskRequest;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TaskController extends Controller
{
    private UserService $userService;
    private User $user;

    public function __construct(Request $request, UserService $userService)
    {
        $this->userService = $userService;
        $this->user = $this->userService->getCurrentUser($request);
    }

    public function index(Project $project): JsonResponse
    {
        // Ensure the project belongs to the authenticated user
        if ($project->user_id !== $this->user->id) {
            return response()->json(['status' => 403, 'message' => 'Unauthorized access to tasks.'], Response::HTTP_FORBIDDEN);
        }

        $tasks = $project->tasks()->orderBy('priority')->get();
        if ($tasks->isNotEmpty()) {
            return response()->json(['status' => 200, 'tasks' => $tasks], Response::HTTP_OK);
        } else {
            return response()->json(['status' => 204, 'tasks' => 'No Data Found'], Response::HTTP_NO_CONTENT);
        }
    }

    public function store(StoreTaskRequest $request, $task = null): JsonResponse
    {
        $validated = $request->validated();

        // Ensure the project belongs to the authenticated user
        $project = Project::find($validated['project_id']);
        if (!$project || $project->user_id !== $this->user->id) {
            return response()->json([
                'message' => 'Unauthorized to add tasks to this project.',
            ], 403);
        }

        if ($task) {
            $task = Task::findOrFail($task);

            // Ensure the task belongs to a project of the authenticated user
            if ($task->project->user_id !== $this->user->id) {
                return response()->json([
                    'message' => 'Unauthorized access to modify this task.',
                ], 403);
            }

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
        // Ensure the task belongs to a project of the authenticated user
        if ($task->project->user_id !== $this->user->id) {
            return response()->json([
                'message' => 'Unauthorized access to delete this task.',
            ], 403);
        }

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

        // Ensure the tasks belong to projects of the authenticated user
        foreach ($validated['tasks'] as $taskData) {
            $task = Task::find($taskData['id']);
            if (!$task || $task->project->user_id !== $this->user->id) {
                return response()->json([
                    'message' => 'Unauthorized access to reorder tasks.',
                ], 403);
            }
        }

        $priority = 1;
        foreach ($validated['tasks'] as $taskData) {
            Task::where('id', $taskData['id'])->update(['priority' => $priority++]);
        }

        return response()->json(['success' => true, 'message' => 'Task order updated successfully.']);
    }
}
