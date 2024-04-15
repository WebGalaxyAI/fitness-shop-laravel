<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    href: {
        type: String,
        required: true,
    },
    inertia: {
        type: Boolean,
        default: true,
    }
});
</script>

<template>
    <Link v-if="inertia"
        :href="href"
        class="block w-full px-4 py-2 text-left text-sm leading-5 text-white hover:bg-red-400 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out"
    >
        <slot />
    </Link>
    <a
        v-else
        :href="href"
        class="block w-full px-4 py-2 text-left text-sm leading-5 text-white hover:bg-red-400 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out"
    >
        <slot />
    </a>
</template>
