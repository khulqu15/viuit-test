<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link, useForm} from '@inertiajs/inertia-vue3';
import { Icon } from '@iconify/vue';

export default {
    components: {
        AppLayout,
        Link,
        Icon,
    },
    data() {
        return {
            show_password: false,
            form: useForm({
                name: '',
                email: '',
                password: '',
                role: 'guest',
            })
        }
    },
    methods: {
        onSubmit() {
            this.form.post(this.route('user.store'), {
                preserveState: true,
                preserveScroll: true
            })
        },
    }
}
</script>

<template>
    <AppLayout title="Product">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                User
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-8">
                        <h1 class="text-2xl font-bold mb-3">Add User</h1>
                        <div class="flex justify-between mb-6">
                            <div>
                                <Link class="btn bg-gray-100 text-black hover:bg-gray-200 border-0" :href="route('users')">
                                    <Icon icon="akar-icons:chevron-left" /> Back
                                </Link>
                            </div>
                        </div>
                        <form class="space-y-4" @submit.prevent="onSubmit()">
                            <div class="grid md:grid-cols-2 grid-cols-1 gap-4">
                                <div class="form-control w-full">
                                    <label class="label">
                                        <span class="label-text">Name</span>
                                    </label>
                                    <input v-model="form.name" required maxlength="100" type="text" placeholder="User Name" class="input input-bordered w-full focus:border-rose-600 focus:outline-bg-rose-400" />
                                </div>
                                <div class="form-control w-full">
                                    <label class="label">
                                        <span class="label-text">Email</span>
                                    </label>
                                    <input v-model="form.email" required maxlength="100" type="email" placeholder="User Email" class="input input-bordered w-full focus:border-rose-600 focus:outline-bg-rose-400" />
                                </div>
                            </div>
                            <div class="grid md:grid-cols-2 grid-cols-1 gap-4">
                                <div class="form-control w-full">
                                    <label class="label">
                                        <span class="label-text">Password</span>
                                    </label>
                                    <input v-model="form.password" required maxlength="100" :type="!show_password ? 'text':'password'" placeholder="User Password" class="input input-bordered w-full focus:border-rose-600 focus:outline-bg-rose-400" />
                                    <label class="cursor-pointer label">
                                        <input v-model="show_password" type="checkbox" checked="checked" class="checkbox checkbox-secondary" />
                                        <span class="label-text">Show password</span>
                                    </label>
                                </div>
                                <div class="form-control w-full">
                                    <label class="label">
                                        <span class="label-text">Role</span>
                                    </label>
                                    <select v-model="form.role" class="select active:border-rose-600">
                                        <option value="guest">Guest</option>
                                        <option value="admin">Admin</option>
                                    </select>
                                </div>
                            </div>
                            <div class="flex justify-end items-center gap-3">
                                <Link :href="route('users')" class="btn btn-ghost">Cancel</Link>
                                <button class="btn bg-rose-400 border-0 hover:bg-rose-500">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
