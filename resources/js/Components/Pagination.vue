<script setup>
import {computed} from "vue";
import Link from "@/Components/Link.vue";
import {usePage} from "@inertiajs/vue3";

const page = usePage();

const props = defineProps({
    total: Number,
    perPage: Number,
    currentPage: Number,
})

const totalPages = computed(() => Math.ceil(props.total / props.perPage));

const generateUrl = (selectedPage) => {
    if ([props.currentPage, '...'].includes(selectedPage)) {
        return 'javascript:void(0);';
    }

    const url = page.url;
    let updatedUrl;
    if (url.includes('page=')) {
        updatedUrl = url.replace(/page=\d+/g, `page=${selectedPage}`);
    } else {
        const separator = url.includes('?') ? '&' : '?';
        updatedUrl = `${url}${separator}page=${selectedPage}`;
    }
    return updatedUrl;
}

const paginationLinks = computed(() => {
    const current = props.currentPage;
    const last = totalPages.value;

    if (last <= 5) {
        return Array.from({length: last}, (_, i) => i + 1);
    } else if (current <= 3) {
        return [1, 2, 3, 4, '...', last];
    } else if (current >= last - 2) {
        return [1, '...', last - 3, last - 2, last - 1, last];
    } else {
        return [1, '...', current - 1, current, current + 1, '...', last];
    }
});

</script>

<template>
    <div v-if="total > 0" class="grid gap-3">
        <div v-if="currentPage < totalPages" class="flex justify-center text-base">
            <button class="show-more"
                    @click="$emit('showMore', generateUrl(currentPage + 1), totalPages)"
            >
                {{ __('Show more') }}
            </button>
        </div>
        <div v-if="totalPages > 1" class="pagination flex justify-center text-base">
            <Link v-for="page in paginationLinks"
                  :href="generateUrl(page)"
                  :key="`page-${page}`">
                <span class="pagination__item"
                      :class="{
                          'pagination__item_active': page === currentPage,
                      }"
                >
                    {{ page }}
                </span>
            </Link>
        </div>
    </div>
</template>

<style scoped lang="scss">
.show-more {
    color: #F53B49;
    font-style: normal;
    font-weight: 700;
    line-height: normal;
}

.pagination__item {
    display: flex;
    padding: 6px 10px;
    flex-direction: column;
    align-items: flex-start;

    color: #909CB5;
    font-style: normal;
    font-weight: 700;
    line-height: normal;
}

.pagination__item_active {
    display: flex;
    padding: 6px 10px;
    flex-direction: column;
    align-items: flex-start;

    color: #1A1A25;
    border-radius: 6px;
    background: #FFF;
}
</style>
