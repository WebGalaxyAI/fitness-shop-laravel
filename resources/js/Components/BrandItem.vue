<script setup>
defineProps({
        brand: Object,
        wrapperClass: {
            default: ''
        },
    }
)
</script>

<template>
    <div class="brand-wrapper flex items-center justify-center cursor-pointer"
         :class="wrapperClass">
        <img
            class="brand-item" :src="brand.logo" :alt="brand.name">
    </div>
</template>

<style scoped lang="scss">
.brand-wrapper {
    background: white;
    border: 1px solid rgba(133, 143, 164, 0.20);
}
</style>
