<template>
    <form @submit.prevent="onSubmit" class="space-y-4">
        <div>
            <label class="block text-sm font-medium text-gray-700"
                >Título</label
            >
            <input
                type="text"
                v-model="form.title"
                class="mt-1 w-full rounded-lg border border-gray-300 p-2"
                required
            />
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700"
                >Descrição</label
            >
            <textarea
                v-model="form.description"
                rows="4"
                class="mt-1 w-full rounded-lg border border-gray-300 p-2"
                required
            ></textarea>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700"
                >Status</label
            >
            <select
                v-model="form.status"
                class="mt-1 w-full rounded-lg border border-gray-300 p-2"
                required
            >
                <option value="pending">Pendente</option>
                <option value="progress">Em Andamento</option>
                <option value="completed">Concluída</option>
            </select>
        </div>
        <button
            type="submit"
            class="rounded-lg bg-blue-500 px-4 py-2 text-white"
        >
            Salvar
        </button>
    </form>
</template>

<script setup>
import { defineProps } from 'vue';

const emit = defineEmits(['submit']);
const props = defineProps({
    task: {
        type: Object,
        default: () => ({ title: '', description: '', status: 'pending' }),
    },
});

const form = {
    ...props.task,
};

function onSubmit() {
    // Emite o formulário preenchido
    emit('submit', form);
}
</script>
