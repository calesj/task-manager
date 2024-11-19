<template>
    <AuthenticatedLayout>
        <Head title="Usuários"></Head>
        <div class="container mx-auto p-6">
            <h1 class="mb-4 text-2xl font-bold text-gray-800">
                Lista de Usuários
            </h1>

            <!-- Tabela -->
            <div class="mb-4 flex">
                <input
                    type="text"
                    v-model="searchTerm"
                    placeholder="Buscar por nome ou email"
                    class="rounded-md border px-4 py-2"
                />
                <button
                    @click="searchUsers(searchTerm)"
                    class="ml-5 rounded-lg bg-blue-500 px-4 py-2 text-white hover:bg-blue-600"
                >
                    Buscar
                </button>
            </div>

            <div class="overflow-x-auto rounded-lg bg-white shadow">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th
                                scope="col"
                                class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-700"
                            >
                                Nome
                            </th>
                            <th
                                scope="col"
                                class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-700"
                            >
                                Email
                            </th>
                            <th
                                scope="col"
                                class="px-6 py-3 text-center text-xs font-medium uppercase tracking-wider text-gray-700"
                            >
                                Tarefas Criadas
                            </th>
                            <th
                                scope="col"
                                class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-700"
                            >
                                Ações
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <tr
                            v-for="user in users.data"
                            :key="user.id"
                            class="hover:bg-gray-50"
                        >
                            <td class="px-6 py-4 text-sm text-gray-700">
                                {{ user.name }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                {{ user.email }}
                            </td>
                            <td
                                class="px-6 py-4 text-center text-sm text-gray-700"
                            >
                                <button
                                    v-if="user.tasks_count > 0"
                                    @click="viewTasks(user.id)"
                                    class="inline-block rounded-full bg-blue-500 px-4 py-1 text-white hover:bg-blue-600 focus:outline-none"
                                    :title="`Ver tarefas de ${user.name}`"
                                >
                                    {{ user.tasks_count }}
                                </button>
                                <span
                                    v-else
                                    class="inline-block rounded-full bg-gray-300 px-4 py-1 text-gray-500"
                                    title="Nenhuma tarefa"
                                >
                                    {{ user.tasks_count }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <button
                                    @click="editUser(user)"
                                    class="flex items-center gap-2 text-sm font-medium text-blue-500 transition-all hover:text-blue-700"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="h-4 w-4"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                        aria-hidden="true"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M11 3h2v14h-2zM5 7l2.5-2.5 12 12L17 19l-12-12L5 7z"
                                        />
                                    </svg>
                                    Editar
                                </button>
                                <button
                                    @click="confirmDelete(user.id)"
                                    class="flex items-center gap-2 text-sm font-medium text-red-500 transition-all hover:text-red-700"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="h-4 w-4"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                        aria-hidden="true"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"
                                        />
                                    </svg>
                                    Excluir
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Card de Formulário -->
            <div
                v-if="showEditForm"
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

                    <h2 class="mb-4 text-lg font-bold">Editar Usuário</h2>

                    <form @submit.prevent="saveUser(form)" class="space-y-4">
                        <div>
                            <label
                                class="block text-sm font-medium text-gray-700"
                                >Nome</label
                            >
                            <input
                                type="text"
                                v-model="form.name"
                                class="mt-1 w-full rounded-lg border border-gray-300 p-2"
                                required
                            />
                        </div>
                        <div>
                            <label
                                class="block text-sm font-medium text-gray-700"
                                >Descrição</label
                            >
                            <textarea
                                v-model="form.email"
                                rows="4"
                                class="mt-1 w-full rounded-lg border border-gray-300 p-2"
                                required
                            ></textarea>
                        </div>
                        <div>
                            <label
                                class="block text-sm font-medium text-gray-700"
                                >Privilégios Administrativos</label
                            >
                            <select
                                v-model="form.is_admin"
                                class="mt-1 w-full rounded-lg border border-gray-300 p-2"
                                required
                            >
                                <option value="0">Não</option>
                                <option value="1">Sim</option>
                            </select>
                        </div>
                        <button
                            type="submit"
                            class="rounded-lg bg-blue-500 px-4 py-2 text-white"
                        >
                            Salvar
                        </button>
                    </form>
                </div>
            </div>

            <!-- Paginação -->
            <Pagination
                :last-page="users.last_page"
                :current-page="users.current_page"
                :next-page-url="users.next_page_url"
                :prev-page-url="users.prev_page_url"
            />
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Pagination from '@/Components/Pagination.vue';
import { nextTick, ref } from 'vue';
import { router } from '@inertiajs/vue3';
import Swal from "sweetalert2";

defineProps({
    users: Object, // Dados paginados do backend
});

const showEditForm = ref(false);

const searchTerm = ref('');
const form = ref(null);

function searchUsers(searchTerm) {
    if (searchTerm) {
        router.get(route('admin.users.index', { search: searchTerm }));
    }
}

function resetForm() {
    form.value = null;
    showEditForm.value = false;
}

function editUser(user) {
    showEditForm.value = false;
    form.value = user;

    // Aguarda o DOM atualizar antes de abrir o modal novamente
    nextTick(() => {
        showEditForm.value = true;
    });
}

function saveUser(form) {
    router.put(route('admin.users.update', form.id), form, {
        onSuccess: () => {
            router.visit(route('admin.users.index'));
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
}

function deleteUser(userId) {
    router.delete(route('admin.users.destroy', userId), {
        onSuccess: () => {
            router.visit(route('admin.users.index'));
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
}

const confirmDelete = (userId) => {
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
            deleteUser(userId);
        }
    });
};

function viewTasks(userId) {
    router.get(route('admin.users.tasks', { id: userId }));
}
</script>
