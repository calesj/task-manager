<template>
    <div class="space-y-4">
        <!-- Exibe as tarefas -->
        <div v-for="task in tasks.data" :key="task.id">
            <TaskItem :task="task" @edit="onEdit" @delete="onDelete" />
        </div>

        <!-- Paginação -->
        <Pagination
            :last-page="tasks.last_page"
            :current-page="tasks.current_page"
            :next-page-url="tasks.next_page_url"
            :prev-page-url="tasks.prev_page_url"
        />
    </div>
</template>

<script setup>
import TaskItem from './TaskItem.vue';
import Pagination from "@/Components/Pagination.vue";

const emit = defineEmits(['edit', 'delete']);

defineProps({
    tasks: {
        type: Object,
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
