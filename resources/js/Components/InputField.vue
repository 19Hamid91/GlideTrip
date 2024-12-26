<template>
    <div class="flex flex-col gap-1 w-full">
        <!-- Label -->
        <p v-if="labelText" class="text-custom-black style-title">
            {{ labelText }}
        </p>

        <!-- Input Wrapper -->
        <div
            v-if="tag === 'input'"
            class="flex items-center gap-3 p-[16px_12px] border border-custom-gray-200 rounded-xl focus-within:border-custom-blue transition-all duration-300"
        >
            <!-- Lead Icon -->
            <div v-if="leadIcon" class="w-4 h-4 flex shrink-0">
                <img :src="leadIcon" alt="icon" />
            </div>

            <!-- Input -->
            <input
                class="custom-appearance-none border-none w-full style-body placeholder:text-custom-gray-200 focus-within:border-transparent"
                :type="inputType"
                :placeholder="placeholderText"
                v-model="model"
                @input="$emit('update:modelValue', model)"
            />

            <!-- Trail Icon -->
            <div v-if="trailIcon" class="w-4 h-4 flex shrink-0">
                <img :src="trailIcon" alt="icon" />
            </div>
        </div>

        <!-- Textarea Wrapper -->
        <div
            v-else-if="tag === 'textarea'"
            class="p-[16px_12px] border border-custom-gray-200 rounded-xl focus-within:border-custom-blue transition-all duration-300"
        >
            <textarea
                class="custom-appearance-none outline-none w-full style-body placeholder:text-custom-gray-200"
                :placeholder="placeholderText"
                v-model="model"
                @input="$emit('update:modelValue', model)"
            ></textarea>
        </div>

        <!-- Error Message -->
        <div v-if="errorText" class="flex flex-col text-custom-red style-body">
            {{ errorText }}
        </div>
    </div>
</template>

<script>
export default {
    props: {
        tag: {
            type: String,
            required: true // 'input' or 'textarea'
        },
        inputType: {
            type: String,
            default: 'text'
        },
        labelText: {
            type: String,
            default: ''
        },
        placeholderText: {
            type: String,
            default: ''
        },
        leadIcon: {
            type: String,
            default: null
        },
        trailIcon: {
            type: String,
            default: null
        },
        errorText: {
            type: String,
            default: null
        },
        modelValue: {
            // Tambahkan prop untuk v-model
            type: String,
            default: ''
        }
    },
    data() {
        return {
            model: this.modelValue // Inisialisasi model dengan nilai dari prop
        };
    },
    watch: {
        model(newValue) {
            this.$emit('update:modelValue', newValue); // Emit perubahan ke parent
        },
        modelValue(newValue) {
            this.model = newValue; // Update model jika prop modelValue berubah
        }
    }
};
</script>
