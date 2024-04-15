<script setup>
import {Link} from '@inertiajs/vue3';

const props = defineProps({
    href: {
        type: String,
        default: 'javascript:void(0);',
    },
})
</script>

<template>
    <button v-if="href == 'javascript:void(0);'">
        <slot/>
    </button>
    <Link v-else
          :href="href">
        <slot/>
    </Link>
</template>

<style scoped lang="scss">
</style>
