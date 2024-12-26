<script setup>
import { ref } from 'vue';
import { usePage, Head, useForm } from '@inertiajs/vue3';
import Navigation from '@/Components/Navigation.vue';
import Button from '@/Components/Button.vue';

const page = usePage();
const banks = page.props.banks || [];
const packageBooking = page.props.packageBooking || [];
const form = useForm({
    package_bank_id: null
});

const handleSubmit = () => {
    form.patch(route('front.choose_bank_store', packageBooking.id), {
        onFinish: () => form.reset('package_bank_id')
    });
};
</script>

<template>
    <Head title="Choose Bank" />
    <section
        id="content"
        class="flex flex-col max-w-[640px] min-h-screen mx-auto w-full bg-custom-background gap-8 pb-8"
    >
        <Navigation text="Checkout" />
        <div class="flex flex-1 flex-col h-full justify-center px-4 gap-8">
            <div class="px-[35px] w-full flex shrink-0">
                <img src="/images/Bank-Account-Illustration.png" alt="background" class="object-contain mx-auto" />
            </div>
            <div
                v-for="(error, index) in form.errors"
                :key="index"
                class="w-full text-white bg-red-500 py-2 rounded-xl px-4"
            >
                {{ error }}
            </div>
            <form @submit.prevent="submit" class="flex flex-col gap-8">
                <div class="flex flex-col gap-3">
                    <p class="font-semibold">Payment Method</p>
                    <div v-for="bank in banks" :key="bank.id" class="bg-white p-[16px_24px] rounded-[26px]">
                        <label :for="bank.bank_name" class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-6 flex shrink-0 overflow-hidden">
                                    <img
                                        :src="bank.logo_url"
                                        alt="logo"
                                        class="w-full h-full object-cover object-center"
                                    />
                                </div>
                                <span class="style-body">{{ bank.bank_name }}</span>
                            </div>
                            <input
                                type="radio"
                                name="payment"
                                :value="bank.id"
                                id="bank.bank_name"
                                v-model="form.package_bank_id"
                                class="w-5 h-5 appearance-none checked:border-[3px] checked:border-solid checked:border-white rounded-full checked:bg-[#6E5DE7] ring-2 ring-[#6E5DE7]"
                            />
                        </label>
                    </div>
                </div>
                <Button @click="handleSubmit" size="medium" text="Checkout" class="mx-auto w-full style-title" />
            </form>
        </div>
    </section>
</template>
