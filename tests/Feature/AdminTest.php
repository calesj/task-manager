<?php

use App\Models\Task;
use App\Models\User;

/** Usuário admin pode atualizar um usuario */
test('admin can update a user', function () {
    $user = User::factory()->create();
    $admin = User::factory()->create(['is_admin' => true]);

    $this->actingAs($admin)->put(route('admin.users.update', $user->id), [
        'name' => 'John Doe',
        'email' => 'john@doe.com',
        'is_admin' => true
    ])->assertRedirect(route('admin.users.index'));

    $this->assertDatabaseHas('users', [
        'id' => $user->id,
        'name' => 'John Doe',
        'email' => 'john@doe.com',
        'is_admin' => true
    ]);
});

/** Usuário admin não pode atualizar um usuario */
test('user cant update a user', function () {
    $user = User::factory()->create();
    $userTwo = User::factory()->create(['is_admin' => false]);

    $this->actingAs($userTwo)->put(route('admin.users.update', $user->id), [
        'name' => 'John Doe',
        'email' => 'john@doe.com',
        'is_admin' => true
    ])->assertStatus(403);

    $this->assertDatabaseHas('users', [
        'id' => $user->id,
        'name' => $user->name,
        'email' => $user->email,
    ]);
});

/** Usuário admin pode deletar um usuário */
test('admin can delete a user', function () {
    $user = User::factory()->create();
    $admin = User::factory()->create(['is_admin' => true]);

    $this->actingAs($admin)
        ->delete(route('admin.users.destroy', $user->id))
        ->assertRedirect(route('admin.users.index'));

    $this->assertDatabaseMissing('users', [
        'id' => $user->id,
    ]);
});

/** Usuário não admin não pode deletar um usuário */
test('user cant delete a user', function () {
    $user = User::factory()->create();
    $userTwo = User::factory()->create(['is_admin' => false]);

    $this->actingAs($userTwo)
        ->delete(route('admin.users.destroy', $user->id))
        ->assertStatus(403);

    $this->assertDatabaseHas('users', [
        'id' => $user->id,
    ]);
});

/** Admin pode criar uma task para outro usuário */
test('Admin can create a task for another user', function () {
    $user = User::factory()->create();
    $admin = User::factory()->create(['is_admin' => true]);

    $this->actingAs($admin)->post(route('admin.tasks.store', $user->id), [
        'title' => 'Title test',
        'description' => 'Description test',
        'status' => 'completed',
    ])->assertRedirect(route('admin.users.tasks', $user->id));

    $this->assertDatabaseHas('tasks', [
        'title' => 'Title test',
        'description' => 'Description test',
        'status' => 'completed',
    ]);
});

/** Usuário não pode criar uma task para outro usuário */
test('user cannot create a task for another user', function () {
    $user = User::factory()->create();
    $userTwo = User::factory()->create(['is_admin' => false]);

    $this->actingAs($userTwo)->post(route('admin.tasks.store', $user->id), [
        'title' => 'Title test',
        'description' => 'Description test',
        'status' => 'completed',
    ])->assertStatus(403);

    $this->assertDatabaseMissing('tasks', [
        'title' => 'Title test',
        'description' => 'Description test',
        'status' => 'completed',
    ]);
});

/** Admin pode editar uma task de outro usuário */
test('user can edit a task for another user', function () {
    $user = User::factory()->create();
    $task = Task::factory()->create(['user_id' => $user->id]);
    $admin = User::factory()->create(['is_admin' => true]);

    $this->actingAs($admin)->put(route('admin.tasks.update', $task->id), [
        'title' => 'Title test',
        'description' => 'Description test',
        'status' => 'completed',
    ])->assertRedirect(route('admin.users.tasks', $user->id));

    $this->assertDatabaseHas('tasks', [
        'id' => $task->id,
        'title' => 'Title test',
        'description' => 'Description test',
        'status' => 'completed',
    ]);
});

/** Usuário não pode editar uma task de outro usuário */
test('user cannot edit a task for another user', function () {
    $user = User::factory()->create();
    $task = Task::factory()->create(['user_id' => $user->id]);
    $userTwo = User::factory()->create(['is_admin' => false]);

    $this->actingAs($userTwo)->put(route('admin.tasks.update', $task->id), [
        'title' => 'Title test',
        'description' => 'Description test',
        'status' => 'completed',
    ])->assertStatus(403);

    $this->assertDatabaseMissing('tasks', [
        'title' => 'Title test',
        'description' => 'Description test',
        'status' => 'completed',
    ]);
});

/** Admin pode deletar uma task de outro usuário */
test('user can delete a task for another user', function () {
    $user = User::factory()->create();
    $task = Task::factory()->create(['user_id' => $user->id]);
    $admin = User::factory()->create(['is_admin' => true]);

    $this->actingAs($admin)
        ->delete(route('admin.tasks.destroy', $task->id))
        ->assertRedirect(route('admin.users.tasks', $user->id));

    $this->assertDatabaseMissing('tasks', [
        'id' => $task->id,
    ]);
});

/** Usuário não pode deletar uma task de outro usuário */
test('user cannot delete a task for another user', function () {
    $user = User::factory()->create();
    $task = Task::factory()->create(['user_id' => $user->id]);
    $userTwo = User::factory()->create(['is_admin' => false]);

    $this->actingAs($userTwo)->delete(route('admin.tasks.destroy', $task->id))->assertStatus(403);

    $this->assertDatabaseHas('tasks', [
        'id' => $task->id,
        'title' => $task->title,
        'description' => $task->description,
    ]);
});



