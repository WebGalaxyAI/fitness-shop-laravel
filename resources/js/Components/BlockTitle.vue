<script setup>
defineProps({
        title: String,
}
)
</script>

<template>
    <h2 class="block-tittle mb-6 text-xl md:text-2xl lg:text-3xl">{{ title }}</h2>
</template>

<style scoped lang="scss">
.block-tittle {
    color: #1A1A25;
    font-style: normal;
    font-weight: 700;
    line-height: 110%; /* 33px */
}
</style>
