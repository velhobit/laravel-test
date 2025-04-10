<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Services\TaskService;

class TaskController extends Controller
{
    protected $tasks;

    public function __construct(TaskService $tasks)
    {
        $this->tasks = $tasks;
    }

    public function index()
    {
        return response()->json($this->tasks->all());
    }

    public function show($uuid)
    {
        return response()->json($this->tasks->find($uuid));
    }

    public function store(Request $request)
    {

       try {
           $data = $request->validate([
               "title" => "string",
               "description" => "required|string|min:6",
               "date" => "nullable|date",
               "time" => "nullable|date_format:H:i",
               "color" => 'nullable|string|size:7|regex:/^#[0-9A-Fa-f]{6}$/',
               'user_id' => 'required|integer|exists:users,id',
           ]);

           $response = $this->tasks->create($data);

           return response()->json($response, 201);
       } catch (\Throwable $e) {
           return response()->json([
               'error' => 'Error creating task',
               'message' => $e->getMessage(),
           ], 500);
       }
    }

   public function update(Request $request, $uuid)
   {
       try {
           $data = $request->validate([
               "title" => "string",
               "description" => "sometimes|string|min:6",
               "date" => "nullable|date",
               "time" => "nullable|date_format:H:i",
               "color" => 'nullable|string|size:7|regex:/^#[0-9A-Fa-f]{6}$/',
               'user_id' => 'sometimes|integer|exists:users,id',
           ]);

           $task = $this->tasks->update($uuid, $data);

           return response()->json($task);
       } catch (\Exception $e) {
           return response()->json([
               'error' => 'Error updating task',
               'message' => $e->getMessage()
           ], 400);
       }
   }


    public function destroy($uuid)
    {
        $this->tasks->delete($uuid);
        return response()->json(['message' => 'Task deleted']);
    }

    public function myTasks()
    {
        $user = auth()->user();
        $tasks = $this->tasks->getByUser($user->id);

        return response()->json($tasks);
    }

}
