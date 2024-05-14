<script setup>
import Link from "@/Components/Link.vue";

defineProps({
    categorySiblings: Array,
})
</script>

<template>
    <div class="flex flex-wrap gap-2">
        <Link v-for="(sibling, index) in categorySiblings"
              :href="route().params.slug === sibling.slug ? 'javascript:void(0);' : route('catalog', sibling.slug)"
              :key="'sibling-cat-'+index">
            <div class="category-sibling text-sm rounded p-2"
                :class="{
                'category-sibling_active': route().params.slug === sibling.slug,
             }">
                {{ sibling.name }}
            </div>
        </Link>
    </div>
</template>

<style scoped lang="scss">
.category-sibling {
    color: var(--txt, #384255);
    font-style: normal;
    font-weight: 700;
    line-height: normal;

    background: rgba(144, 156, 181, 0.20);

    &_active {
        background: #F53B49;
        color: white;
    }
}
</style>
