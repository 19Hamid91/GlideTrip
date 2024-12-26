<template>
    <button
        :type="buttonType"
        :class="buttonClasses"
        class="rounded-xl justify-center items-center gap-3 inline-flex cursor-pointer transition-all duration-300"
        :disabled="isDisabled"
    >
        <div v-if="icon" class="w-6 h-6 relative">
            <img :src="icon" alt="icon" class="w-full h-full object-cover" />
        </div>
        <div :class="textClass">{{ text }}</div>
    </button>
</template>

<script>
export default {
    props: {
        size: {
            type: String,
            default: 'large' // large, medium, small
        },
        state: {
            type: String,
            default: 'primary' // primary, secondary, tertiary, hover, disabled
        },
        icon: {
            type: String,
            default: null
        },
        text: {
            type: String,
            required: true
        },
        buttonType: {
            type: String,
            default: 'button' // button, submit, reset
        }
    },
    computed: {
        isDisabled() {
            return this.state === 'disabled';
        },
        buttonClasses() {
            let baseClasses = 'px-6 py-4 inline-flex justify-center items-center gap-3';
            let sizeClasses = '';
            let stateClasses = '';

            // Size classes
            switch (this.size) {
                case 'large':
                    sizeClasses = 'w-80 h-16';
                    break;
                case 'medium':
                    sizeClasses = 'w-80 h-14';
                    break;
                case 'small':
                    sizeClasses = 'h-14';
                    break;
            }

            // State classes
            switch (this.state) {
                case 'primary':
                    stateClasses = 'bg-custom-blue hover:bg-custom-green text-white';
                    break;
                case 'secondary':
                    stateClasses =
                        'bg-transparent hover:bg-custom-blue text-custom-blue hover:text-white border border-custom-blue';
                    break;
                case 'tertiary':
                    stateClasses = 'bg-transparent text-custom-blue';
                    break;
                case 'disabled':
                    stateClasses = 'bg-[#cccccc] text-[#666666] cursor-not-allowed';
                    break;
            }

            return `${baseClasses} ${sizeClasses} ${stateClasses}`;
        },
        textClass() {
            let textSize = '';
            if (this.size === 'large') {
                textSize = 'text-2xl';
            } else if (this.size === 'medium') {
                textSize = 'text-sm';
            } else if (this.size === 'small') {
                textSize = 'text-sm';
            }
            return `${textSize} style-button`;
        }
    }
};
</script>
