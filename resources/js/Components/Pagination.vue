<template>
    <div class="pagination">
        <button
            v-for="link in links"
            :key="link.url"
            @click="goToPage(link.url)"
            :disabled="!link.url"
            :class="{ 'text-gray-500': !link.url, 'text-indigo-700': link.url }"
        >
            {{ link.label }}
        </button>
    </div>
</template>

<script setup>
defineProps({
    links: Array
});

const emit = defineEmits(['go-to-page']);

const goToPage = (url) => {
    if (url) {
        emit('go-to-page', url);
    }
};
</script>
