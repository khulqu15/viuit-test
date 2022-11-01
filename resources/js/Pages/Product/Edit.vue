<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link, useForm} from '@inertiajs/inertia-vue3';
import { Icon } from '@iconify/vue';

export default {
    props: ['product'],
    mixin: ['formatting_time'],
    components: {
        AppLayout,
        Link,
        Icon,
    },
    data() {
        return {
            preview: null,
            form: useForm({
                name: '',
                price: '',
                description: '',
                photo: null,
                _method: 'PATCH',
            })
        }
    },
    mounted() {
        this.form.name = this.product.name
        this.form.price = this.product.price
        this.form.description = this.product.description
    },
    methods: {
        changeFile(e) {
            let file = e.target.files[0]
            this.preview = URL.createObjectURL(file)
            this.form.photo = file
        },
        onSubmit() {
            this.form.post(this.route('product.update', this.product.hash), {
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
                                <Link class="btn bg-gray-100 text-black hover:bg-gray-200 border-0" :href="route('products')">
                                    <Icon icon="akar-icons:chevron-left" /> Back
                                </Link>
                            </div>
                        </div>
                        <form class="space-y-4" @submit.prevent="onSubmit()">
                            <div class="flex gap-4">
                                <div class="form-control w-full">
                                    <label class="label">
                                        <span class="label-text">Name</span>
                                    </label>
                                    <input v-model="form.name" required maxlength="100" type="text" placeholder="Product Name" class="input input-bordered w-full focus:border-rose-600 focus:outline-bg-rose-400" />
                                </div>
                                <div class="form-control w-full">
                                    <label class="label">
                                        <span class="label-text">Price</span>
                                    </label>
                                    <input v-model="form.price" required maxlength="100" type="number" placeholder="Product Price" class="input input-bordered w-full focus:border-rose-600 focus:outline-bg-rose-400" />
                                </div>
                            </div>
                            <div class="form-control w-full">
                                <label class="label">
                                    <span class="label-text">Description</span>
                                </label>
                                <textarea v-model="form.description" required maxlength="100" type="text" placeholder="Product Name" class="textarea textarea-bordered w-full focus:border-rose-600 focus:outline-bg-rose-400" ></textarea>
                            </div>
                            <div class="flex justify-center gap-6 items-center">
                                <div class="text-center">
                                    <div class="w-48 flex justify-center overflow-hidden items-center h-48 inline-block rounded-lg bg-rose-400">
                                        <div v-if="preview === null">
                                            <div v-if="product.photo">
                                                <img :src="`/img/product/${product.photo}`" alt="Preview Photo" class="w-full h-full object-cover object-center">
                                            </div>
                                            <div v-else>
                                                <Icon icon="akar-icons:image" class="text-white text-4xl" />
                                            </div>
                                        </div>
                                        <div v-else>
                                            <img :src="preview" alt="Preview Photo" class="w-full h-full object-cover object-center">
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <label for="photo-product" class="btn">Change image</label>
                                    <input @change="changeFile($event)" type="file" class="hidden" id="photo-product">
                                </div>
                            </div>
                            <div class="flex justify-end items-center gap-3">
                                <Link :href="route('products')" class="btn btn-ghost">Cancel</Link>
                                <button class="btn bg-rose-400 border-0 hover:bg-rose-500">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
