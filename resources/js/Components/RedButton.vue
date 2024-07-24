<script setup>
import {Link} from '@inertiajs/vue3';

const props = defineProps({
    text: {
        type: String
    },
    textXS: {
        type: Boolean,
        default: false,
    },
    href: {
        type: String,
        default: 'javascript:void(0);',
    },
})

</script>

<template>
    <button v-if="href === 'javascript:void(0);'"
            :class="[
                'inline-flex justify-center items-center px-5 py-3 gap-2 rounded-md bg-custom-red text-white font-bold',
                textXS ? 'text-xs lg:text-sm' : 'text-sm md:text-base lg:text-lg xl:text-xl'
            ]"
    >
        {{ text }}
    </button>
    <Link v-else :href="href">
        <button :class="[
                'inline-flex justify-center items-center px-5 py-3 gap-2 rounded-md bg-custom-red text-white font-bold',
                textXS ? 'text-xs lg:text-sm' : 'text-sm md:text-base lg:text-lg xl:text-xl'
            ]"
        >
            {{ text }}
        </button>
    </Link>
</template>

<style scoped lang="scss">
.red-button {
    display: inline-flex;
    padding: 12px 20px 13px 20px;
    justify-content: center;
    align-items: center;
    gap: 10px;
    border-radius: 4px;
    background: #F53B49;
    color: #FFF;

    font-size: 14px;
    font-style: normal;
    font-weight: 700;
    line-height: normal;
}
</style>
