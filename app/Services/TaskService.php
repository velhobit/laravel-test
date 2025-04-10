<?php
namespace App\Services;

use App\Models\Task;

class TaskService
{
    public function all()
    {
        return Task::with('user')->get();
    }

    public function find($uuid)
    {
        return Task::with('user')->findOrFail($uuid);
    }

    public function create(array $data)
    {
        $task = Task::create($data);
        $task->load('user');
        return $task;
    }

    public function update($uuid, array $data)
    {
        $task = Task::with('user')->findOrFail($uuid);
        $task->update($data);
        return $task;
    }

    public function delete($uuid)
    {
        $task = Task::with('user')->findOrFail($uuid);
        return $task->delete();
    }

    public function getByUser($userId)
    {
        return Task::with('user')->where('user_id', $userId)->get();
    }
}
