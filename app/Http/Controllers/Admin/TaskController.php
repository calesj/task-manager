<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\Filters;
use App\Http\Requests\TaskRequest;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TaskController extends Controller
{
    use Filters;

    public function __construct(
        private readonly Task $task,
        private readonly User $user
    )
    {}

    /** Cadastrar tarefa */
    public function store(string $id, TaskRequest $request)
    {
        $validated = $request->validated();

        $user = $this->user->find($id);

        if (!$user) {
            abort(404);
        }

        $this->task->create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'status' => $validated['status'],
            'user_id' => $user->id
        ]);

        return redirect()->route('admin.users.tasks', ['id' => $id]);
    }

    /** Atualizar tarefa */
    public function update(string $id, TaskRequest $request)
    {
        /** Buscando a tarefa */
        $task = $this->task->where(['id' => $id])->firstOrFail();

        if (!$task) {
            return response('Unauthorized.', 401);
        }

        $validated = $request->validated();

        $task->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'status' => $validated['status'],
        ]);

        return to_route('admin.users.tasks', $task->user_id);
    }

    /** Destruir tarefa */
    public function destroy(string $id)
    {
        /** Buscando a tarefa vinculada ao usuario */
        $task = $this->task->where(['id' => $id])->firstOrFail();
        $task->delete();

        return redirect()->back();
    }

    /** Listagem de tarefas de um usuário em especifico */
    public function tasksByUser(string $id, Request $request)
    {
        $query = $this->task->where(['user_id' => $id]);
        $tasks = $this->filters($request, $query);

        if ($tasks->isEmpty()) {
            return response()->json(['status' => 204]);
        }

        return Inertia::render('Admin/Task/Index',
            [
                'tasks' => $tasks,
                'filters' => $request->only(['status', 'orderBy', 'direction']),
                'userId' => $id
            ]
        );
    }
}
