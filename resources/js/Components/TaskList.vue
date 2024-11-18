<template>
    <div class="space-y-4">
        <!-- Exibe as tarefas -->
        <div v-for="task in tasks.data" :key="task.id">
            <TaskItem :task="task" @edit="onEdit" @delete="onDelete" />
        </div>

        <!-- Controles de Paginação -->
        <div class="mt-4 flex justify-center">
            <Link
                :href="tasks.prev_page_url ?? '#'"
                @click.prevent="goToPage(tasks.prev_page_url)"
                :class="{
                    'cursor-not-allowed opacity-50': !tasks.prev_page_url,
                    'bg-blue-500 hover:bg-blue-600': tasks.prev_page_url,
                }"
                class="rounded-md bg-blue-500 px-4 py-2 text-white hover:bg-blue-600 disabled:bg-gray-300"
            >
                Anterior
            </Link>
            <Link
                :href="tasks.next_page_url ?? '#'"
                @click.prevent="goToPage(tasks.prev_page_url)"
                :disabled="!tasks.next_page_url"
                :class="{
                    'cursor-not-allowed opacity-50': !tasks.next_page_url,
                    'bg-blue-500 hover:bg-blue-600': tasks.next_page_url,
                }"
                class="ml-4 rounded-md bg-blue-500 px-4 py-2 text-white hover:bg-blue-600 disabled:bg-gray-300"
            >
                Próxima
            </Link>
        </div>
    </div>
</template>

<script setup>
import TaskItem from './TaskItem.vue';
import { Link } from '@inertiajs/vue3';

const emit = defineEmits(['edit', 'delete']);

defineProps({
    tasks: {
        type: Array || Object,
        required: true,
    },
});

const onEdit = function (task) {
    emit('edit', task);
};

const onDelete = function (taskId) {
    emit('delete', taskId);
};
</script>
