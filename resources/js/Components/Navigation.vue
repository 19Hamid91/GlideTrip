<template>
    <nav class="mt-8 px-4 w-full flex items-center justify-between">
        <Link v-show="leadIcon" :href="previousLink">
            <img src="/images/back.svg" alt="back" />
        </Link>
        <p class="text-center m-auto font-semibold">{{ text }}</p>
        <Link v-show="trailIcon" href="/">
            <img src="/images/triple-dot.svg" alt="more" />
        </Link>
    </nav>
</template>
<script setup>
import { Link, usePage } from '@inertiajs/vue3';

const props = defineProps({
    leadIcon: {
        type: Boolean,
        default: true
    },
    text: {
        type: String,
        default: null
    },
    trailIcon: {
        type: Boolean,
        default: false
    }
});

const page = usePage();
const previousLink = page.props.previous || '/';
</script>
