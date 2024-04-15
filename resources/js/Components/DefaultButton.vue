<script setup>
import {Link} from '@inertiajs/vue3';
import {onMounted} from "vue";

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

onMounted(() => {
    document.body.classList.remove('overflow-hidden');
})
</script>

<template>
    <button v-if="href == 'javascript:void(0);'"
            class="slider-button"
            :class="{
                    'text-sm md:text-base lg:text-lg xl:text-xl': !textXS,
                    'text-xs lg:text-sm': textXS

                }"
    >
        {{ text }}
    </button>
    <Link v-else
          :href="href">
        <button class="slider-button"
                :class="{
                    'text-sm md:text-base lg:text-lg xl:text-xl': !textXS,
                    'text-xs lg:text-sm': textXS
                }"
        >
            {{ text }}
        </button>
    </Link>
</template>

<style scoped lang="scss">
.slider-button {
    display: flex;
    padding: 0.5em 1em;
    justify-content: center;
    align-items: center;
    gap: 10px;

    border-radius: 4px;
    border: 1px solid #F53B49;

    color: #F53B49;
    font-style: normal;
    font-weight: 700;
    line-height: normal;

    &:hover {
        background: white;
    }
}
</style>
