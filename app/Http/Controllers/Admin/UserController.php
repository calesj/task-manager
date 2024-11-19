<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    public function __construct(
        private readonly User $user
    )
    {}

    public function index(Request $request)
    {
        /** Retorna listagem de usuários, com a quantidade de tasks vinculadas a cada um */
        $query = $this->user->withCount('tasks')->orderByDesc('created_at');

        /** Verifica se existe um campo 'search' na url */
        if ($request->input('search')) {
            $query->where('name', 'like', '%' . $request->input('search') . '%')
                ->orWhere('email', 'like', '%' . $request->input('search') . '%');
        }
        $users = $query->paginate(7);
        return Inertia::render('Admin/Users/Index', ['users' => $users]);
    }

    /** Atualiza usuário */
    public function update(string $id, UserRequest $request)
    {
        $user = $this->user->findOrFail($id);

        $user->update($request->validated());

        return to_route('admin.users.index');
    }

    /** Deleta Usuário */
    public function destroy(string $id)
    {
        $user = $this->user->findOrFail($id);
        $user->delete();
        return to_route('admin.users.index');
    }
}
