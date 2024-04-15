<script setup>
import {computed} from 'vue';
import {Link} from '@inertiajs/vue3';

const props = defineProps({
    href: {
        type: String,
        required: true,
    },
    active: {
        type: Boolean,
    },
});

const classes = computed(() =>
    props.active
        ? 'nav-link_active flex items-center justify-center'
        : 'nav-link flex items-center justify-center'
);
</script>

<template>
    <Link :href="href"
        :class="classes">
        <slot/>
    </Link>
</template>

<style scoped lang="scss">
.nav-link_active {
    display: flex;
    padding: 0.4em 0.8em;
    align-items: flex-start;
    color: white;
    font-size: 14px;

    border-radius: 6px;
    background: #384255;
}

.nav-link {
    display: flex;
    padding: 0.4em 0.8em;
    align-items: flex-start;
    color: #909CB5;
    font-size: 14px;

    &:hover {
        color: white;

        border-radius: 6px;
        background: rgba(30, 144, 255, 0.6);
    }
}
</style>
