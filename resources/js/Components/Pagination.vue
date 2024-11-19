<template>
    <div class="mt-4 flex items-center justify-between">
        <!-- Página Anterior -->
        <Link
            :href="prevPageUrl ?? '#'"
            :class="{
                'cursor-not-allowed opacity-50': !prevPageUrl,
                'bg-blue-500 hover:bg-blue-600': prevPageUrl,
            }"
            class="rounded-md bg-blue-500 px-4 py-2 text-white hover:bg-blue-600 disabled:bg-gray-300"
        >
            Anterior
        </Link>

        <!-- Página Atual -->
        <p class="text-sm text-gray-700">
            Página {{ currentPage }} de {{ lastPage }}
        </p>

        <!-- Próxima Página -->
        <Link
            :href="nextPageUrl ?? '#'"
            :disabled="!nextPageUrl"
            :class="{
                'cursor-not-allowed opacity-50': !nextPageUrl,
                'bg-blue-500 hover:bg-blue-600': nextPageUrl,
            }"
            class="ml-4 rounded-md bg-blue-500 px-4 py-2 text-white hover:bg-blue-600 disabled:bg-gray-300"
        >
            Próxima
        </Link>
    </div>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
defineProps({
    prevPageUrl: {
        type: String,
        required: null,
    },
    nextPageUrl: {
        type: String,
        required: null,
    },
    currentPage: {
        type: Number,
        required: true,
    },
    lastPage: {
        type: Number,
        required: true,
    },
});
</script>
