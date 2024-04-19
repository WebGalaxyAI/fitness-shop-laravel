<script setup>
import {computed, ref} from "vue";
import {useMouseInElement} from "@vueuse/core";
import Link from "@/Components/Link.vue";

defineProps({
        item: Object,
        wrapperClass: {
            default: ''
        },
        titleClass: {
            default: ''
        }
    }
)

//3D animation on hover
const target = ref(null)
const {elementX, elementY, isOutside, elementHeight, elementWidth} = useMouseInElement(target)
const buttonTransform = computed(() => {
    const MAX_ROTATION = 20;

    const rX = (
        MAX_ROTATION / 2 - elementY.value / elementHeight.value * MAX_ROTATION
    ).toFixed(2)
    const rY = (
        elementX.value / elementWidth.value * MAX_ROTATION - MAX_ROTATION / 2
    ).toFixed(2)

    return isOutside.value ? '' : `perspective(${elementWidth.value}px) rotateX(${rX}deg) rotateY(${rY}deg)`
})
</script>

<template>
<!--    :href="route('catalog', item.slug)"-->
    <Link ref="target"
         :style="{
                transform: buttonTransform,
                transition: 'transform 0.25s ease-out'
             }"
         class="image-card relative overflow-hidden cursor-pointer"
        :class="wrapperClass">
        <div class="image-card__title p-7 absolute z-[30] w-24 text-base xl:text-lg xl:w-48"
             :class="titleClass">
            {{ item.name }}
        </div>
        <img
            class="absolute z-[10] bottom-0 right-0 max-w-fit max-h-full"
            :src="item.image"
            :alt="item.name + ' image'"
        />
    </Link>
</template>


<style scoped lang="scss">
@import "./resources/scss/_variables.scss";

.image-card {
    border-radius: 6px;
    background: #F0F1F7;

    &__title {
        color: #1A1A25;
        font-style: normal;
        font-weight: 800;
        line-height: 120%; /* 24px */
        &_white {
            color: white;
        }
    }
}

.bg-dark-site {
    background: $main-dark;
}
</style>
