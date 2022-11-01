<script setup>
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import { Head, Link, usePage } from '@inertiajs/inertia-vue3';
import { Icon } from '@iconify/vue';
import Banner from '@/Components/Banner.vue';

defineProps({
    title: String,
});

const { flash } = usePage().props

const showingNavigationDropdown = ref(false);

const switchToTeam = (team) => {
    Inertia.put(route('current-team.update'), {
        team_id: team.id,
    }, {
        preserveState: false,
    });
};

const logout = () => {
    Inertia.post(route('logout'));
};
</script>

<template>
    <div>
        <Head :title="title" />

        <Banner />

        <div class="min-h-screen bg-gray-100">
            <div class="drawer">
                <input id="my-drawer" type="checkbox" class="drawer-toggle" />
                <div class="drawer-content">
                    <div class="w-full navbar px-8 bg-white shadow-lg flex justify-between items-center">
                        <div>
                            <label for="my-drawer" class="swap cursor-pointer">
                                <input type="checkbox" class="opacity-0"/>
                                <Icon class="swap-off fill-current text-xl" icon="akar-icons:toggle-off-fill" />
                                <Icon class="swap-on fill-current text-xl" icon="akar-icons:toggle-on-fill" />
                            </label>
                            <header v-if="$slots.header">
                                <div class="max-w-7xl mx-auto px-4">
                                    <slot name="header" />
                                </div>
                            </header>
                        </div>
                        <div>
                            <div class="dropdown dropdown-bottom dropdown-end dropdown-hover">
                                <label tabindex="0" class="btn btn-ghost">{{ $page.props.user.name }}</label>
                                <ul tabindex="0" class="dropdown-content menu p-2 shadow bg-base-100 rounded-box w-52">
                                    <li><Link class="active:bg-rose-400" :href="route('profile.show')">Profile</Link></li>
                                    <li><button class="active:bg-rose-400" @click="logout()">Logout</button></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- Page Content -->
                    <main>
                        <slot />

                        <div class="toast">
                            <div v-if="$page.props.flash.success" class="alert alert-success">
                                <div>
                                    <span>{{ $page.props.flash.success }}</span>
                                </div>
                            </div>
                            <div v-if="$page.props.flash.error" class="alert alert">
                                <div>
                                    <span>{{ $page.props.flash.error }}</span>
                                </div>
                            </div>
                        </div>

                    </main>
                </div>
                <div class="drawer-side">
                    <label for="my-drawer" class="drawer-overlay"></label>
                    <ul class="menu p-4 overflow-y-auto w-80 bg-base-100 text-base-content">
                        <!-- Sidebar content here -->
                        <div class="flex items-center justify-center my-4 gap-2">
                            <img src="/img/logo.png" class="w-12" alt="Logo ViuIT">
                            <span class="text-xl font-bold">ViuIT Transaction</span>
                        </div>
                        <li>
                            <Link :class="{'bg-rose-400 text-white shadow': route().current('dashboard')}" class="active:bg-rose-400" :href="route('dashboard')">Dashboard</Link>
                        </li>
                        <li>
                            <Link :class="{'bg-rose-400 text-white shadow': route().current('products')}" class="active:bg-rose-400" :href="route('products')">Product</Link>
                        </li>
                        <li v-if="$page.props.user.role === 'admin'">
                            <Link :class="{'bg-rose-400 text-white shadow': route().current('transactions')}" class="active:bg-rose-400" :href="route('transactions')">Transaction</Link>
                        </li>
                        <li v-if="$page.props.user.role === 'admin'">
                            <Link :class="{'bg-rose-400 text-white shadow': route().current('users')}" class="active:bg-rose-400" :href="route('users')">User</Link>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>
