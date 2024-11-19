<template>
    <AuthenticatedLayout>
        <Head title="Tarefas" />
        <div class="container mx-auto p-8">
            <div class="mb-6 flex items-center justify-between">
                <h1 class="text-2xl font-bold">Gerenciamento de Tarefas</h1>
                <button
                    @click="openCreateForm"
                    class="rounded-lg bg-green-500 px-4 py-2 text-white transition-colors hover:bg-green-600"
                >
                    Nova Tarefa
                </button>
            </div>

            <!-- Filtros -->
            <div class="mb-4 flex items-center gap-4">
                <div>
                    <label
                        for="status"
                        class="block text-sm font-medium text-gray-700"
                        >Status</label
                    >
                    <select
                        id="status"
                        v-model="filters.status"
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm"
                    >
                        <option value="all">Todos</option>
                        <option value="pending">Pendente</option>
                        <option value="progress">Em Andamento</option>
                        <option value="completed">Concluído</option>
                    </select>
                </div>

                <div>
                    <label
                        for="orderBy"
                        class="block text-sm font-medium text-gray-700"
                        >Ordenar por</label
                    >
                    <select
                        id="orderBy"
                        v-model="filters.orderBy"
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm"
                    >
                        <option value="created_at">Data de Criação</option>
                        <option value="updated_at">Data de Atualização</option>
                    </select>
                </div>

                <div>
                    <label
                        for="direction"
                        class="block text-sm font-medium text-gray-700"
                        >Ordem</label
                    >
                    <select
                        id="direction"
                        v-model="filters.direction"
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm"
                    >
                        <option value="asc">Crescente</option>
                        <option value="desc">Decrescente</option>
                    </select>
                </div>

                <button
                    @click="applyFilters"
                    class="mt-6 rounded-lg bg-blue-500 px-4 py-2 text-white hover:bg-blue-600"
                >
                    Aplicar Filtros
                </button>
            </div>

            <!-- Card de Formulário -->
            <div
                v-if="showCreateForm"
                class="fixed inset-0 z-50 flex items-center justify-center bg-gray-800 bg-opacity-50"
            >
                <div
                    class="relative w-full max-w-lg rounded-lg bg-white p-6 shadow-lg"
                >
                    <!-- Botão de Fechar -->
                    <button
                        @click="resetForm"
                        class="absolute right-4 top-4 text-gray-500 hover:text-gray-800"
                    >
                        &times;
                    </button>

                    <h2 class="mb-4 text-lg font-bold">
                        {{ editingTask ? 'Editar Tarefa' : 'Nova Tarefa' }}
                    </h2>

                    <TaskForm :task="editingTask" @submit="saveTask" />
                </div>
            </div>

            <TaskList :tasks="tasks" @edit="editTask" @delete="confirmDelete" />
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { Head, router } from '@inertiajs/vue3';
import { nextTick, ref } from 'vue';
import TaskList from '@/Components/TaskList.vue';
import TaskForm from '@/Components/TaskForm.vue';
import { usePage } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Swal from 'sweetalert2';

defineProps({
    userId: {
        required: true,
    },
});

const { props } = usePage();
const tasks = ref(props.tasks || []);
const showCreateForm = ref(false);
const editingTask = ref(null);

// Filtros
const filters = ref({
    status: props.filters.status || 'all', // Padrão para 'Todos'
    orderBy: props.filters.orderBy || 'created_at',
    direction: props.filters.direction || 'desc',
});

const applyFilters = () => {
    const queryParams = {
        status: filters.value.status,
        orderBy: filters.value.orderBy,
        direction: filters.value.direction,
    };

    router.get(route('dashboard'), queryParams);
};

const resetForm = () => {
    showCreateForm.value = false;
    editingTask.value = null;
};

const openCreateForm = () => {
    resetForm(); // Garante que o formulário esteja limpo
    showCreateForm.value = true;
};

const saveTask = (task) => {
    if (task.id) {
        router.put(route('admin.tasks.update', task.id), task, {
            onSuccess: () => {
                router.visit(route('admin.users.tasks', props.userId));
                resetForm();
                Swal.fire({
                    icon: 'success',
                    title: 'Atualizado com Sucesso!',
                    confirmButtonText: 'Fechar',
                });
            },
            onError: (errors) => {
                const errorMessages = Object.values(errors).flat();

                Swal.fire({
                    icon: 'error',
                    title: 'Erro na validação',
                    html: errorMessages.join('<br>'),
                    confirmButtonText: 'Fechar',
                });
            },
        });
    } else {
        router.post(route('admin.tasks.store', props.userId), task, {
            onSuccess: () => {
                router.visit(route('admin.users.tasks', props.userId));
                resetForm();
                Swal.fire({
                    icon: 'success',
                    title: 'Tarefa criada com sucesso!',
                    confirmButtonText: 'Fechar',
                });
            },
            onError: (errors) => {
                const errorMessages = Object.values(errors).flat();

                Swal.fire({
                    icon: 'error',
                    title: 'Erro na validação',
                    html: errorMessages.join('<br>'),
                    confirmButtonText: 'Fechar',
                });
            },
        });
    }
    resetForm();
};

const editTask = (task) => {
    // Fecha temporariamente o modal para forçar re-renderização
    showCreateForm.value = false;

    // Atualiza os valores da tarefa em edição
    editingTask.value = { ...task };

    // Aguarda o DOM atualizar antes de abrir o modal novamente
    nextTick(() => {
        showCreateForm.value = true;
    });
};

const confirmDelete = (taskId) => {
    Swal.fire({
        title: 'Tem certeza?',
        text: 'Essa ação não poderá ser desfeita!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sim, deletar!',
        cancelButtonText: 'Cancelar',
    }).then((result) => {
        if (result.isConfirmed) {
            // Envia a requisição para deletar a tarefa
            deleteTask(taskId);
        }
    });
};

const deleteTask = (taskId) => {
    router.delete(route('admin.tasks.destroy', taskId), {
        onSuccess: () => {
            router.visit(route('admin.users.tasks', props.userId));
            resetForm();
            Swal.fire({
                icon: 'success',
                title: 'Tarefa deletada com sucesso!',
                confirmButtonText: 'Fechar',
            });
        },
        onError: (errors) => {
            const errorMessages = Object.values(errors).flat();

            Swal.fire({
                icon: 'error',
                title: 'Erro ao deletar',
                html: errorMessages.join('<br>'),
                confirmButtonText: 'Fechar',
            });
        },
    });
};
</script>
