<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import Pagination from '@/Components/Pagination.vue'
import {Link, useForm} from '@inertiajs/inertia-vue3';
import { Icon } from '@iconify/vue';

export default {
    props: ['users'],
    components: {
        AppLayout,
        Pagination,
        Link,
        Icon,
    },
    mixin: ['formatting_time'],
    data() {
        return {
            selected: '',
            form: useForm({
                name: '',
                sort: 'desc',
                role: '',
            })
        }
    },
    methods: {
        search(sort) {
            form.sort = sort
            form.get(route('users'), {
                preserveState: true,
            })
        },
        onDelete() {
            this.$inertia.delete(this.route('user.destroy', this.selected), {
                preserveScroll: true,
                preserveState: true,
                onFinish: () => {
                    document.getElementById('modal-delete').click()
                }
            })
        }
    }
}
</script>

<template>
    <AppLayout title="User">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Product
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-8">
                        <h1 class="text-2xl font-bold mb-3">Users</h1>
                        <div class="flex justify-between mb-6">
                            <div>
                                <Link :href="route('user.create')" class="btn bg-rose-400 border-0">Add User</Link>
                            </div>
                            <div>
                                <div class="flex justify-end items-center gap-3">
                                    <input @keyup="search(form.sort)" v-model="form.name" type="text" placeholder="Search by name" class="input focus:border-red-700 focus:outline-red-500 input-bordered w-full" />
                                    <select @change="search(form.sort)" v-model="form.role" class="select active:border-rose-600">
                                        <option value="">All Role</option>
                                        <option value="guest">Guest</option>
                                        <option value="admin">Admin</option>
                                    </select>
                                    <div class="dropdown dropdown-end dropdown-hover dropdown-bottom">
                                        <label tabindex="0" class="btn btn-ghost">
                                            <Icon icon="bxs:sort-alt" />
                                        </label>
                                        <ul tabindex="0" class="dropdown-content menu p-2 shadow bg-base-100 rounded-box w-52">
                                            <li><button class="active:bg-rose-500" @click.prevent="search('desc')">Paling baru</button></li>
                                            <li><button class="active:bg-rose-500" @click.prevent="search('asc')">Paling lama</button></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="overflow-x-auto">
                            <div v-if="users.data.length > 0">
                                <table class="table w-full">
                                    <thead>
                                    <tr>
                                        <th></th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(item, index) in users.data" :key="`product-${item.id}-${index}`">
                                        <th>{{ (users.current_page - 1) * users.per_page + index + 1 }}</th>
                                        <td>{{ item.name }}</td>
                                        <td>{{ item.email }}</td>
                                        <td>{{ item.role }}</td>
                                        <td>
                                            <div class="space-x-2">
                                                <Link :href="route('user.edit', item.hash)" class="btn btn-success">Edit</Link>
                                                <label @click="selected = item.hash" for="modal-delete" class="btn btn-error">Hapus</label>
                                            </div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <Pagination :data="users" />
                            </div>
                            <div v-else class="text-center">
                                <img src="/img/Blank%20canvas-amico%201.png" class="inline-block w-1/2" alt="empty data">
                                <h2 class="text-2xl font-bold">Product Not Found</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <input type="checkbox" id="modal-delete" class="modal-toggle" />
            <label for="modal-delete" class="modal modal-bottom sm:modal-middle">
                <label for="" class="modal-box text-center">
                    <h3 class="font-bold text-lg">Hapus User ?</h3>
                    <p class="py-4">Data user akan hilang secara permanen dari sistem</p>
                    <div class="modal-action">
                        <label for="modal-delete" class="btn btn-ghost">Batal</label>
                        <button @click="onDelete()" class="btn btn-error">Hapus</button>
                    </div>
                </label>
            </label>
        </div>
    </AppLayout>
</template>
