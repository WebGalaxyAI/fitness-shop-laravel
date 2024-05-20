<script setup>
import {computed} from 'vue';
import {Link} from '@inertiajs/vue3';

const props = defineProps({
    href: {
        type: String,
        required: true,
    },
    active: {
        type: Boolean,
    },
    count: {
        type: Number,
    },
});

const classes = computed(() =>
    props.active
        ? 'nav-link_active'
        : 'nav-link'
);
</script>

<template>
    <Link :href="href" :class="classes">
        <div class="counter-box">
            <div class="counter">
                <div class="count">{{ count }}</div>
            </div>
            <slot/>
        </div>
    </Link>
</template>

<style scoped lang="scss">

.counter-box {
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    width: 30px;
    height: 30px;
}

.counter {
    position: absolute;
    top: 0;
    right: -10px;
    border-radius: 100%;
    display: flex;
    align-items: center;
    justify-content: center;

    background: #F53B49;
    width: 18px;
    height: 18px;
    .count {
        color: white;
        font-size: 10px;
    }
}
.nav-link_active {
    display: flex;
    align-items: flex-start;
    color: white;
    font-size: 14px;

    border-radius: 6px;
    background: #384255;
}

.nav-link {
    display: flex;
    align-items: flex-start;
    color: #909CB5;
    font-size: 14px;

    &:hover {
        color: white;

        border-radius: 6px;
        background: rgba(30, 144, 255, 0.6);
    }
}
</style>
