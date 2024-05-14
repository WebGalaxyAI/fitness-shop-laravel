<script setup>
import Link from "@/Components/Link.vue";

const props = defineProps({
    breadcrumbs: {
        type: Array,
        required: true,
    },
});

</script>

<template>
    <div v-if="breadcrumbs.length" class="breadcrumbs-wrapper flex items-center space-x-2 text-sm">
        <svg
            xmlns="http://www.w3.org/2000/svg"
            width="15"
            height="16"
            viewBox="0 0 15 16"
            fill="none"
        >
            <path
                d="M14.6896 7.87711L7.87425 0.664272C7.82518 0.612198 7.76689 0.570885 7.70273 0.542697C7.63856 0.514509 7.56978 0.5 7.50031 0.5C7.43084 0.5 7.36206 0.514509 7.29789 0.542697C7.23373 0.570885 7.17544 0.612198 7.12637 0.664272L0.311065 7.87711C0.112513 8.08739 0 8.37303 0 8.67094C0 9.28953 0.474871 9.79247 1.05895 9.79247H1.77704V14.9392C1.77704 15.2494 2.01365 15.5 2.30652 15.5H6.44136V11.5746H8.29452V15.5H12.6941C12.987 15.5 13.2236 15.2494 13.2236 14.9392V9.79247H13.9417C14.223 9.79247 14.4927 9.67506 14.6912 9.46302C15.1032 9.02492 15.1032 8.3152 14.6896 7.87711Z"
                fill="#B9C0CF"
            />
        </svg>
        <template v-for="(crumb, index) in breadcrumbs" :key="'crumb-'+index">
            <Link :href="crumb.url">
                {{ crumb.title }}
                <span v-if="index < breadcrumbs.length - 1">»</span>
            </Link>
        </template>
    </div>
</template>

<style scoped lang="scss">
.breadcrumbs-wrapper {
    color: rgba(56, 66, 85, 0.60);
    font-style: normal;
    font-weight: 400;
    line-height: 140%; /* 19.6px */
}
</style>
