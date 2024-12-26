<template>
    <div
        :class="[
            'w-fit border p-[4px_8px] rounded-lg flex items-center justify-center',
            `border-custom-badge-${color}-border`,
            `bg-custom-badge-${color}-background`
        ]"
    >
        <span :class="`style-caption text-custom-badge-${color}-text`">{{ text }}</span>
    </div>
</template>
<script>
export default {
    props: {
        color: {
            type: String,
            default: 'blue'
        },
        text: {
            type: String,
            default: ''
        }
    }
};
</script>
