<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import Pagination from '@/Components/Pagination.vue'
import { Link, useForm } from '@inertiajs/inertia-vue3';
import { Icon } from '@iconify/vue';

export default {
    mixin: ['formatting_time'],
    props: ['products'],
    components: {
        AppLayout,
        Pagination,
        Link,
        Icon,
    },
    data() {
        return {
            selected: null,
            form: useForm({
                name: '',
                sort: 'desc',
            }),
            transaction: useForm({
                quantity: 1,
                product_id: null
            })
        }
    },
    methods: {
        search(sort) {
            this.form.sort = sort
            this.form.get(this.route('products'), {
                preserveState: true,
            })
        },
        onDelete() {
            this.$inertia.delete(this.route('product.destroy', this.selected), {
                preserveScroll: true,
                onFinish: () => {
                    document.getElementById('modal-delete').click()
                }
            })
        },
        onBuy() {
            this.transaction.product_id = this.products.data.find(item => item.hash === this.selected).id
            this.transaction.post(this.route('transaction.store'), {
                preserveScroll: true,
                preserveState: true,
                onFinish: () => {
                    document.getElementById('modal-transaction').click()
                }
            })
        },
    }
}
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
                                <Link v-if="$page.props.user.role === 'admin'" :href="route('product.create')" class="btn bg-rose-400 border-0">Add Product</Link>
                            </div>
                            <div>
                                <div class="flex justify-end items-center gap-3">
                                    <input @keyup="search(form.sort)" v-model="form.name" type="text" placeholder="Search by name" class="input focus:border-red-700 focus:outline-red-500 input-bordered w-full" />
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
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(item, index) in products.data" :key="`product-${item.id}-${index}`">
                                        <th>{{ (products.current_page - 1) * products.per_page + index + 1 }}</th>
                                        <td>{{ item.name }}</td>
                                        <td>{{ item.price }}</td>
                                        <td>
                                            <div v-if="!item.photo">
                                                <span>No Photo</span>
                                            </div>
                                            <div v-else>
                                                <div class="w-24 h-24 rounded-xl overflow-hidden">
                                                    <img class="w-full h-full object-cover object-center" :src="`/img/product/${item.photo}`" alt="">
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ formatting_time(item.created_at) }}</td>
                                        <td>
                                            <div class="space-x-2">
                                                <div v-if="$page.props.user.role === 'admin'" class="space-x-2">
                                                    <Link :href="route('product.edit', item.hash)" class="btn btn-success">Edit</Link>
                                                    <label @click="selected = item.hash" for="modal-delete" class="btn btn-error">Delete</label>
                                                </div>
                                                <div v-else>
                                                    <label @click="selected = item.hash" for="modal-transaction" class="btn btn-success">Buy</label>
                                                </div>
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
            <div v-if="$page.props.user.role === 'admin'">
                <input type="checkbox" id="modal-delete" class="modal-toggle" />
                <label for="modal-delete" class="modal modal-bottom sm:modal-middle">
                    <label for="" class="modal-box text-center">
                        <h3 class="font-bold text-lg">Hapus Produk ?</h3>
                        <p class="py-4">Data produk akan hilang secara permanen dari sistem</p>
                        <div class="modal-action">
                            <label for="modal-delete" class="btn btn-ghost">Cancel</label>
                            <button @click="onDelete()" class="btn btn-error">Delete</button>
                        </div>
                    </label>
                </label>
            </div>
            <div v-else>
                <input type="checkbox" id="modal-transaction" class="modal-toggle" />
                <label for="modal-transaction" class="modal modal-bottom sm:modal-middle">
                    <label for="" class="modal-box text-left">
                        <h3 class="font-bold text-xl">Beli Produk</h3>
                        <form class="space-y-3">
                            <div class="form-control w-full">
                                <label class="label">
                                    <span class="label-text">Quantity</span>
                                </label>
                                <input type="text" required v-model="transaction.quantity" placeholder="Type here" class="input input-bordered w-full" />
                            </div>
                        </form>
                        <div class="modal-action">
                            <label for="modal-transaction" class="btn btn-ghost">Cancel</label>
                            <button @click="onBuy()" class="btn btn-success">Buy Now: {{ selected ? products.data.find(item => item.hash === selected).price * transaction.quantity : '' }}</button>
                        </div>
                    </label>
                </label>
            </div>
        </div>
    </AppLayout>
</template>
