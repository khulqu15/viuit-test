<template>
    <div class="flex justify-between items-center">
        <div>
            <div class="btn-group">
                <Link class="btn btn-ghost" preserve-state :href="data.prev_page_url ? data.prev_page_url : '#'">
                    <Icon icon="akar-icons:chevron-left" />
                </Link>
                <button class="btn btn-ghost">Page {{ data.current_page }}</button>
                <Link class="btn btn-ghost" preserve-state :href="data.next_page_url ? data.next_page_url : '#'">
                    <Icon icon="akar-icons:chevron-right" />
                </Link>
            </div>
        </div>
        <div>Total: {{ data.total }}, Perpage: {{ data.per_page }}</div>
    </div>
    <br>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue3';
import { Icon } from '@iconify/vue';

export default {
    props: ['data'],
    name: "Pagination",
    components: {
        Link,
        Icon,
    }
}
</script>

<style scoped>

</style>
