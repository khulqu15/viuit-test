<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import Pagination from '@/Components/Pagination.vue'
import {Link, useForm} from '@inertiajs/inertia-vue3';
import { Icon } from '@iconify/vue';

export default {
    props: ['transactions'],
    components: {
        AppLayout,
        Pagination,
        Link,
        Icon
    },
    mixin: ['formatting_time'],
    data() {
        return {
            selected: '',
            form: useForm({
                name: '',
                sort: 'desc',
                from_date: null,
                to_date: null,
            }),
            calendar: {
                start: '',
                end: '',
            }
        }
    },
    methods: {
        search(sort) {
            this.form.from_date = this.calendar.start
            this.form.to_date = this.calendar.end
            this.form.sort = sort
            this.form.get(this.route('transactions'), {
                preserveState: true,
                preserveScroll: true,
            })
        },
        onDelete() {
            this.$inertia.delete(this.route('transaction.destroy', this.selected), {
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
    <AppLayout title="Product">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Transaction
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-8">
                        <h1 class="text-2xl font-bold mb-3">Transactions</h1>
                        <div class="grid grid-cols-4 gap-4">
                            <div class="lg:col-span-1 col-span-4">
                                <div class="space-y-4 mb-6">
                                    <div>
                                        <div class="flex justify-end items-center gap-3">
                                            <input @keyup="search(form.sort)" v-model="form.name" type="text" placeholder="Search by product name" class="input focus:border-red-700 focus:outline-red-500 input-bordered w-full" />
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
                                    <div>
                                        <v-date-picker @click="search(form.sort)" class="w-full" color="red" is-expanded v-model="calendar" is-range/>
                                    </div>
                                </div>

                            </div>
                            <div class="lg:col-span-3 col-span-6">
                                <div class="overflow-x-auto">
                                    <div v-if="transactions.data.length > 0">
                                        <table class="table w-full">
                                            <thead>
                                            <tr>
                                                <th></th>
                                                <th>Product</th>
                                                <th>User</th>
                                                <th>Code Transaction</th>
                                                <th>Status</th>
                                                <th>Created at</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr v-for="(item, index) in transactions.data" :key="`product-${item.id}-${index}`">
                                                <th>{{ (transactions.current_page - 1) * transactions.per_page + index + 1 }}</th>
                                                <td>{{ item.product.name }}</td>
                                                <td>{{ item.user.name }}</td>
                                                <td>{{ item.code }}</td>
                                                <td>{{ item.status }}</td>
                                                <td>{{ formatting_time(item.created_at) }}</td>
                                                <td>
                                                    <div class="space-x-2">
                                                        <Link :href="route('transaction.edit', item.hash)" class="btn btn-success">Edit</Link>
                                                        <label @click="selected = item.hash" for="modal-delete" class="btn btn-error">Hapus</label>
                                                    </div>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <Pagination :data="transactions" />
                                    </div>
                                    <div v-else class="text-center">
                                        <img src="/img/Blank%20canvas-amico%201.png" class="inline-block w-1/2" alt="empty data">
                                        <h2 class="text-2xl font-bold">Transactions Not Found</h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <input type="checkbox" id="modal-delete" class="modal-toggle" />
            <label for="modal-delete" class="modal modal-bottom sm:modal-middle">
                <label for="" class="modal-box text-center">
                    <h3 class="font-bold text-lg">Hapus Transaksi ?</h3>
                    <p class="py-4">Data produk akan hilang secara permanen dari sistem</p>
                    <div class="modal-action">
                        <label for="modal-delete" class="btn btn-ghost">Batal</label>
                        <button @click="onDelete" class="btn btn-error">Hapus</button>
                    </div>
                </label>
            </label>
        </div>
    </AppLayout>
</template>
