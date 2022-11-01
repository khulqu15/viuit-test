<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link, useForm} from '@inertiajs/inertia-vue3';
import { Icon } from '@iconify/vue';

export default {
    props: ['transaction'],
    mixin: ['formatting_time'],
    components: {
        AppLayout,
        Link,
        Icon,
    },
    data() {
        return {
            preview: null,
            information: {
                code: '',
                product: '',
                user: '',
            },
            form: useForm({
                quantity: '',
                status: '',
                verified_at: false,
                _method: 'PATCH',
            })
        }
    },
    mounted() {
        this.information.code = this.transaction.code
        this.information.product = this.transaction.product.name
        this.information.user = this.transaction.user.name
        this.form.quantity = this.transaction.quantity
        this.form.verified_at = !!this.transaction.verified_at
        this.form.status = this.transaction.status
    },
    methods: {
        changeFile(e) {
            let file = e.target.files[0]
            this.preview = URL.createObjectURL(file)
            this.form.photo = file
        },
        onSubmit() {
            this.form.post(this.route('transaction.update', this.transaction.hash), {
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
                Product
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-8">
                        <h1 class="text-2xl font-bold mb-3">Edit Product</h1>
                        <div class="flex justify-between mb-6">
                            <div>
                                <Link class="btn bg-gray-100 text-black hover:bg-gray-200 border-0" :href="route('transactions')">
                                    <Icon icon="akar-icons:chevron-left" /> Back
                                </Link>
                            </div>
                        </div>
                        <form class="space-y-4" @submit.prevent="onSubmit()">
                            <div class="grid md:grid-cols-3 grid-cols-1 gap-4">
                                <div class="form-control w-full">
                                    <label class="label">
                                        <span class="label-text">Code</span>
                                    </label>
                                    <input v-model="information.code" required maxlength="100" type="text" placeholder="Transaction Code" disabled readonly class="input input-bordered w-full focus:border-rose-600 focus:outline-bg-rose-400" />
                                </div>
                                <div class="form-control w-full">
                                    <label class="label">
                                        <span class="label-text">Product</span>
                                    </label>
                                    <input v-model="information.product" required maxlength="100" type="text" placeholder="Product Name" disabled class="input input-bordered w-full focus:border-rose-600 focus:outline-bg-rose-400" />
                                </div>
                                <div class="form-control w-full">
                                    <label class="label">
                                        <span class="label-text">User</span>
                                    </label>
                                    <input v-model="information.user" required maxlength="100" type="text" placeholder="User Name" disabled class="input input-bordered w-full focus:border-rose-600 focus:outline-bg-rose-400" />
                                </div>
                            </div>
                            <div>
                                <div class="form-control w-full">
                                    <label class="label">
                                        <span class="label-text">Quantity</span>
                                    </label>
                                    <input v-model="form.quantity" required maxlength="100" type="text" placeholder="Quantity Product" class="input input-bordered w-full focus:border-rose-600 focus:outline-bg-rose-400" />
                                </div>
                            </div>
                            <div class="grid md:grid-cols-2 grid-cols-1 space-y-3 items-center">
                                <div class="flex items-center gap-6">
                                    <div>
                                        <input type="radio" v-model="form.status" name="radio-8" value="pending" class="radio radio-error" />
                                        <label for="">Pending</label>
                                    </div>
                                    <div>
                                        <input type="radio" v-model="form.status" name="radio-8" value="process" class="radio radio-error" />
                                        <label for="">Process</label>
                                    </div>
                                    <div>
                                        <input type="radio" v-model="form.status" name="radio-8" value="done" class="radio radio-error" />
                                        <label for="">Done</label>
                                    </div>
                                </div>
                                <div class="md:text-end space-x-4">
                                    <div class="inline-block">
                                        <label class="cursor-pointer label">
                                            <input v-model="form.verified_at" type="checkbox" class="toggle mr-4 toggle-secondary" checked />
                                            <span class="label-text">Verify</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="flex justify-end items-center gap-3">
                                <Link :href="route('transactions')" class="btn btn-ghost">Cancel</Link>
                                <button class="btn bg-rose-400 border-0 hover:bg-rose-500">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
