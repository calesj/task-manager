<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Models\Task;
use Inertia\Inertia;

class TaskController extends Controller
{
    public function __construct(
        private readonly Task $task
    )
    {}
    public function index()
    {
        $tasks = $this->task->orderByDesc('created_at')->userTasks()->paginate(5);
        return Inertia::render('Task', ['tasks' => $tasks]);
    }

    public function store(TaskRequest $request)
    {
        $validated = $request->validated();

        $this->task->create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'status' => $validated['status'],
            'user_id' => $request->user()->id
        ]);

        return to_route('tasks.index');
    }

    public function update(string $id, TaskRequest $request)
    {
        /** Buscando a tarefa vinculada ao usuario */
        $task = $this->task->where(['id' => $id, 'user_id' => $request->user()->id])->firstOrFail();

        if (!$task) {
            return response('Unauthorized.', 401);
        }

        $validated = $request->validated();

        $task->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'status' => $validated['status'],
        ]);

        return to_route('tasks.index');
    }

    public function delete(string $id)
    {

    }
}
