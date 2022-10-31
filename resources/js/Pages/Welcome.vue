<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';
import LayoutHeader from "@/Components/LayoutHeader.vue";

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
});
</script>

<template>
    <Head title="Welcome" />
    <div class="min-h-screen relative w-full overflow-hidden">
        <LayoutHeader/>
        <div class="container relative z-10 mx-auto px-12">
            <div class="grid grid-cols-2 gap-6 items-center">
                <div class="md:col-span-1 col-span-2 md:my-12 my-48 space-y-2">
                    <h1 class="text-4xl font-bold"><span class="text-rose-600">ViuIT</span> : Transaction Test</h1>
                    <span class="inline-block mb-8">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas eget libero in velit sodales ornare laoreet et diam.
                    </span>
                    <div class="pt-4 space-x-4">
                        <Link :href="route('login')" class="btn bg-rose-500 border-0 hover:bg-rose-600">Get Started Now</Link>
                        <a href="https://viuit.id/" target="_blank" class="btn bg-gray-200 border-0 hover:bg-gray-300 text-black">About Us</a>
                    </div>
                </div>
                <div class="min-h-screen flex justify-center items-center">
                    <img src="/img/Online%20transactions-amico%201.png" alt="Online Transaction">
                </div>
            </div>
        </div>
        <img src="/img/decoration1.png" class="w-1/2 absolute right-0 bottom-0" alt="">

    </div>
</template>
