<?php

use App\Models\Task;
use App\Models\User;
use function Pest\Laravel\post;

/** Usuário logado criando uma task */
test('authenticated user can create a task', function () {

    /** Criando usuario falso */
    $user = User::factory()->create();

    /** Criando uma tarefa, como usuário falso */
    $this->actingAs($user)->post(route('tasks.store'), [
        'title' => 'Task title',
        'description' => 'Task description',
        'status' => 'pending',
    ])->assertRedirect(route('dashboard'));

    $this->assertDatabaseHas('tasks', [
        'title' => 'Task title',
        'description' => 'Task description',
        'status' => 'pending',
    ]);
});

/** Usuário não logado não pode criar uma task */
test('unauthenticated cant create a task', function () {
    post(route('tasks.store'), [
        'title' => 'Task title',
        'description' => 'Task description',
        'status' => 'pending',
    ])->assertRedirect(route('login'));
});

/** Usuário logado pode editar uma task */
test('authenticated user can edit their own task', function () {
    $user = User::factory()->create();

    $task = Task::factory()->create(['user_id' => $user->id]);

    $this->actingAs($user)->put(route('tasks.update', $task->id), [
        'title' => 'Updated task title',
        'description' => 'Updated task description',
        'status' => 'completed',
    ])->assertRedirect(route('dashboard'));

    $this->assertDatabaseHas('tasks', [
        'id' => $task->id,
        'title' => 'Updated task title',
        'description' => 'Updated task description',
        'status' => 'completed',
    ]);
});

/** Usuário não logado não pode editar uma task */
test('unauthenticated user cant edit their task', function () {
    $task = Task::factory()->create();

    $this->put(route('tasks.update', $task->id), [
        'title' => 'Updated task title',
        'description' => 'Updated task description',
        'status' => 'completed',
    ])->assertRedirect(route('login'));
});

/** Usuário logado pode deletar sua task */
test('authenticated user can delete their own task', function () {
    $user = User::factory()->create();

    $task = Task::factory()->create(['user_id' => $user->id]);

    $this->actingAs($user)->delete(route('tasks.destroy', $task->id))->assertRedirect(route('dashboard'));

    $this->assertDatabaseMissing('tasks', [
        'id' => $task->id,
    ]);
});

/** Usuário não logado não pode deletar sua task */
test('unauthenticated user cant delete their own task', function () {
    $task = Task::factory()->create();

    $this->delete(route('tasks.destroy', $task->id))->assertRedirect(route('login'));

    $this->assertDatabaseHas('tasks', [
        'id' => $task->id,
    ]);
});
