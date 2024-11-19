<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\Filters;
use App\Http\Requests\TaskRequest;
use App\Models\Task;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TaskController extends Controller
{
    use Filters;

    public function __construct(
        private readonly Task $task
    )
    {}

    /** Listar tarefas (somente as suas) */
    public function index(Request $request)
    {
        $query = $this->task->userTasks();

        $tasks = $this->filters($request, $query);

        return Inertia::render('Task/Index',
            [
                'tasks' => $tasks,
                'filters' => $request->only(['status', 'orderBy', 'direction'])
            ]
        );
    }

    /** Cadastrar tarefa */
    public function store(TaskRequest $request)
    {
        $validated = $request->validated();

        $this->task->create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'status' => $validated['status'],
            'user_id' => $request->user()->id
        ]);

        return to_route('dashboard');
    }

    /** Atualizar tarefa */
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

        return to_route('dashboard');
    }

    /** Destruir tarefa */
    public function destroy(string $id)
    {
        /** Buscando a tarefa vinculada ao usuario */
        $task = $this->task->where(['id' => $id, 'user_id' => auth()->user()->id])->firstOrFail();
        $task->delete();

        return to_route('dashboard');
    }
}
