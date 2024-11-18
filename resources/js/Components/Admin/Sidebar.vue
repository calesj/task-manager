<script setup>
import { DataTable, Button, Column, Rating, Tag } from 'primevue';
import { ref, reactive } from "vue";


const products = reactive([
    {
        id: '1000',
        code: 'f230fh0g3',
        name: 'Bamboo Watch',
        description: 'Product Description',
        image: 'bamboo-watch.jpg',
        price: 65,
        category: 'Accessories',
        quantity: 24,
        inventoryStatus: 'INSTOCK',
        rating: 5
    },
]);
const formatCurrency = (value) => {
    return value.toLocaleString('en-US', {
        style: 'currency',
        currency: 'USD',
    });
};
const getSeverity = (product) => {
    switch (product.inventoryStatus) {
        case 'INSTOCK':
            return 'success';

        case 'LOWSTOCK':
            return 'warn';

        case 'OUTOFSTOCK':
            return 'danger';

        default:
            return null;
    }
};

const showSidebar = ref(false);
</script>
<template>
    <div class="relative flex min-h-screen space-y-6">
        <!-- Sidebar -->
        <div
            class="duration-400 absolute inset-y-0 left-0 w-64 -translate-x-full transform space-y-6 bg-slate-900 px-2 py-4 text-white transition ease-in-out md:relative md:-translate-x-0"
            :class="{ 'relative -translate-x-0': showSidebar }"
        >
            <a href="" class="flex items-center space-x-2 px-4">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    class="size-10"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M4.5 12a7.5 7.5 0 0 0 15 0m-15 0a7.5 7.5 0 1 1 15 0m-15 0H3m16.5 0H21m-1.5 0H12m-8.457 3.077 1.41-.513m14.095-5.13 1.41-.513M5.106 17.785l1.15-.964m11.49-9.642 1.149-.964M7.501 19.795l.75-1.3m7.5-12.99.75-1.3m-6.063 16.658.26-1.477m2.605-14.772.26-1.477m0 17.726-.26-1.477M10.698 4.614l-.26-1.477M16.5 19.794l-.75-1.299M7.5 4.205 12 12m6.894 5.785-1.149-.964M6.256 7.178l-1.15-.964m15.352 8.864-1.41-.513M4.954 9.435l-1.41-.514M12.002 12l-3.75 6.495"
                    />
                </svg>
                <span class="text-2xl font-extrabold text-white"
                    >Manager Task</span
                >
            </a>
            <nav>
                <a
                    href="/"
                    class="duration-400 group flex items-center space-x-2 rounded px-4 py-3 transition hover:bg-slate-950 hover:text-slate-400"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="size-6"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"
                        />
                    </svg>
                    <span class="text-white">Dashboard</span>
                </a>

                <a
                    href="/"
                    class="duration-400 group flex items-center space-x-2 rounded px-4 py-3 transition hover:bg-slate-950 hover:text-slate-400"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="size-6"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M6 6.878V6a2.25 2.25 0 0 1 2.25-2.25h7.5A2.25 2.25 0 0 1 18 6v.878m-12 0c.235-.083.487-.128.75-.128h10.5c.263 0 .515.045.75.128m-12 0A2.25 2.25 0 0 0 4.5 9v.878m13.5-3A2.25 2.25 0 0 1 19.5 9v.878m0 0a2.246 2.246 0 0 0-.75-.128H5.25c-.263 0-.515.045-.75.128m15 0A2.25 2.25 0 0 1 21 12v6a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 18v-6c0-.98.626-1.813 1.5-2.122"
                        />
                    </svg>

                    <span class="text-white">Tasks</span>
                </a>

                <a
                    href="/"
                    class="duration-400 group flex items-center space-x-2 rounded px-4 py-3 transition hover:bg-slate-950 hover:text-slate-400"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="size-6"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z"
                        />
                    </svg>

                    <span class="text-white">Users</span>
                </a>
                <a
                    href="/"
                    class="duration-400 group flex items-center space-x-2 rounded px-4 py-3 transition hover:bg-slate-950 hover:text-slate-400"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="size-6"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z"
                        />
                    </svg>

                    <span class="text-white">Admins</span>
                </a>
                <a href="/"></a>
                <a href="/"></a>
            </nav>
        </div>
        <!-- Main Content -->
        <div class="flex-1">
            <!-- Header -->
            <div class="bg-white px-2 py-4 shadow">
                <button
                    @click="showSidebar = !showSidebar"
                    class="font-extrabold text-slate-900"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="size-8"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"
                        />
                    </svg>
                </button>
            </div>
            <div class="p-8">
                <div class="card">
                    <DataTable :value="products" tableStyle="min-width: 50rem" rowStyleClass="background-color: white">
                        <template #header>
                            <div
                                class="flex flex-wrap items-center justify-between gap-2"
                            >
                                <span class="text-xl font-bold">Products</span>
                                <Button icon="pi pi-refresh" rounded raised />
                            </div>
                        </template>
                        <Column field="name" header="Name"></Column>
                        <Column header="Image">
                            <template #body="slotProps">
                                <img
                                    :src="`https://primefaces.org/cdn/primevue/images/product/${slotProps.data.image}`"
                                    :alt="slotProps.data.image"
                                    class="w-24 rounded"
                                />
                            </template>
                        </Column>
                        <Column field="price" header="Price">
                            <template #body="slotProps">
                                {{ formatCurrency(slotProps.data.price) }}
                            </template>
                        </Column>
                        <Column field="category" header="Category"></Column>
                        <Column field="rating" header="Reviews">
                            <template #body="slotProps">
                                <Rating
                                    :modelValue="slotProps.data.rating"
                                    readonly
                                />
                            </template>
                        </Column>
                        <Column header="Status">
                            <template #body="slotProps">
                                <Tag
                                    :value="slotProps.data.inventoryStatus"
                                    :severity="getSeverity(slotProps.data)"
                                />
                            </template>
                        </Column>
                        <template #footer>
                            In total there are
                            {{
                                products ? products.length : 0
                            }}
                            products.</template
                        >
                    </DataTable>
                </div>
            </div>
        </div>
    </div>
</template>
