<template>
    <div class="flex items-center justify-between rounded-lg bg-white p-6 shadow-lg hover:shadow-xl transition-shadow">
        <!-- Informações da Tarefa -->
        <div class="flex-1">
            <h3 class="text-xl font-semibold text-gray-800">{{ task.title }}</h3>
            <p class="text-sm text-gray-500 mt-1">{{ task.description }}</p>
        </div>

        <!-- Status e Ações -->
        <div class="flex items-center gap-6">
            <!-- Badge de Status -->
            <span
                :class="{
                    'bg-yellow-100 text-yellow-600': task.status === 'pending',
                    'bg-blue-100 text-blue-600': task.status === 'progress',
                    'bg-green-100 text-green-600': task.status === 'completed',
                }"
                class="inline-block py-1 px-3 rounded-full text-xs font-semibold uppercase"
            >
                {{ statusTranslation(task.status) }}
            </span>

            <!-- Botão Editar -->
            <button
                @click="$emit('edit', task)"
                class="text-blue-500 hover:text-blue-700 font-medium text-sm flex items-center gap-2 transition-all"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3h2v14h-2zM5 7l2.5-2.5 12 12L17 19l-12-12L5 7z" />
                </svg>
                Editar
            </button>

            <!-- Botão Excluir -->
            <button
                @click="$emit('delete', task.id)"
                class="text-red-500 hover:text-red-700 font-medium text-sm flex items-center gap-2 transition-all"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
                Excluir
            </button>
        </div>
    </div>
</template>

<script setup>
defineProps({
    task: {
        type: Object,
        required: true,
    },
});

const statusTranslation = (status) => {
    const statusTranslations = {
        pending: 'Pendente',
        progress: 'Em Progresso',
        completed: 'Concluída',
    };
    return statusTranslations[status] || status;
};
</script>
