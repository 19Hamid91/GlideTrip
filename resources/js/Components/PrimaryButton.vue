<template>
    <button
        :type="buttonType"
        class="bg-custom-blue p-[16px_24px] w-full max-w[311px] rounded-[10px] text-center text-white font-semibold hover:bg-custom-green transition-all duration-300"
    >
        <slot />
    </button>
</template>
<script>
export default {
    props: {
        buttonType: {
            type: String,
            default: 'button'
        }
    }
};
</script>
