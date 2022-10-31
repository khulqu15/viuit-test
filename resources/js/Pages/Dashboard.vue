<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';

defineProps({
    counts: Array
})
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-8">
                        <h1 class="text-2xl mb-6 font-bold">Report Data</h1>
                        <div class="grid md:grid-cols-2 grid-cols-1 items-center justify-center gap-6">
                            <div class="grid gap-6 grid-cols-1">
                                <div class="p-4 text-center hover:bg-rose-500 hover:text-white transition-all bg-gray-50 rounded-xl">
                                    <h1 class="text-4xl font-bold">{{ counts.product }}</h1>
                                    <span class="text-lg">Product</span>
                                </div>
                                <div class="p-4 text-center hover:bg-rose-500 hover:text-white transition-all bg-gray-50 rounded-xl">
                                    <h1 class="text-4xl font-bold">{{ counts.transaction }}</h1>
                                    <span class="text-lg">Transaction</span>
                                </div>
                                <div v-if="counts.user" class="p-4 text-center hover:bg-rose-500 hover:text-white transition-all bg-gray-50 rounded-xl">
                                    <h1 class="text-4xl font-bold">{{ counts.user }}</h1>
                                    <span class="text-lg">User</span>
                                </div>
                            </div>
                            <div class="text-center">
                                <img src="/img/Site%20Stats-amico%201.png" class="w-3/4 inline-block" alt="decoration2">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
