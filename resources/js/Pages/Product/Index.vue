<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Pagination from '@/Components/Pagination.vue'
import {Head, Link, useForm} from '@inertiajs/inertia-vue3';
import { Icon } from '@iconify/vue';

mixin: ['formatting_time']

const form = useForm({
    name: '',
    sort: '',
})

const search = (sort = null) => {
    if(sort !== null)
        form.sort = sort

    form.get(route('products'), {
        preserveState: true,
    })
}

defineProps({
    products: Array
})
</script>

<template>
    <AppLayout title="Product">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Product
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-8">
                        <h1 class="text-2xl font-bold mb-3">Products</h1>
                        <div class="flex justify-between mb-6">
                            <div>
                                <Link class="btn bg-rose-400 border-0">Tambah Data</Link>
                            </div>
                            <div>
                                <div class="flex justify-end items-center gap-3">
                                    <input @keyup="search" v-model="form.name" type="text" placeholder="Search by name" class="input focus:border-red-700 focus:outline-red-500 input-bordered w-full" />
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
                            <div v-if="products.data.length > 0">
                                <table class="table w-full">
                                    <thead>
                                    <tr>
                                        <th></th>
                                        <th>Name</th>
                                        <th>Price</th>
                                        <th>Photo</th>
                                        <th>Uploaded at</th>
                                        <th v-if="$page.props.user.role === 'admin'">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(item, index) in products.data" :key="`product-${item.id}-${index}`">
                                        <th>{{ (products.current_page - 1) * products.per_page + index + 1 }}</th>
                                        <td>{{ item.name }}</td>
                                        <td>{{ item.price }}</td>
                                        <td>{{ item.photo ? 'No Photo' : item.photo }}</td>
                                        <td>{{ formatting_time(item.created_at) }}</td>
                                        <td>
                                            <div class="space-x-2">
                                                <Link class="btn btn-success">Edit</Link>
                                                <label for="modal-delete" class="btn btn-error">Hapus</label>
                                            </div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <Pagination :data="products" />
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
                    <h3 class="font-bold text-lg">Hapus Produk ?</h3>
                    <p class="py-4">Data produk akan hilang secara permanen dari sistem</p>
                    <div class="modal-action">
                        <label for="modal-delete" class="btn btn-ghost">Batal</label>
                        <button class="btn btn-error">Hapus</button>
                    </div>
                </label>
            </label>
        </div>
    </AppLayout>
</template>
