<script setup>
import { ref } from 'vue';
import { Head, usePage, useForm } from '@inertiajs/vue3';
import Navigation from '@/Components/Navigation.vue';
import Button from '@/Components/Button.vue';

const page = usePage();
const package_booking = page.props.packageBooking || [];
const fileName = ref(null);
const fileInput = ref(null);
const buttonState = ref('disabled');

const form = useForm({
    _method: 'patch',
    proof: ''
});

const copyText = (text) => {
    navigator.clipboard.writeText(text);
};
const formatCurrency = (value) => {
    value = parseFloat(value);
    return `Rp ${value.toLocaleString('id-ID')}`;
};
const triggerFileInput = () => {
    fileInput.value.click();
};
const handleFileChange = (event) => {
    if (event.target.files[0]) {
        form.proof = event.target.files[0];
        fileName.value = event.target.files[0].name;
        buttonState.value = 'primary';
    } else {
        fileName.value = null;
    }
};
const handleSubmit = () => {
    form.post(route('front.book_payment_store', package_booking.id), {
        onFinish: () => form.reset('proof')
    });
};
</script>
<template>
    <Head title="Payment" />
    <section
        id="content"
        class="flex flex-col max-w-[640px] w-full mx-auto bg-custom-background min-h-screen gap-8 pb-[120px]"
    >
        <Navigation text="Payment" />
        <div
            v-for="(error, index) in form.errors"
            :key="index"
            class="w-full text-white bg-red-500 py-2 rounded-xl px-4"
        >
            {{ error }}
        </div>
        <form @submit.prevent="submit" class="flex flex-col gap-8">
            <div class="flex flex-col gap-3 px-4">
                <p class="font-semibold">Detail trip</p>
                <div class="bg-white p-4 rounded-[26px] flex items-center gap-3">
                    <div class="w-[72px] h-[72px] flex shrink-0 rounded-xl overflow-hidden">
                        <img
                            :src="package_booking.tour.thumbnail_url"
                            alt="thumbnail"
                            class="w-full h-full object-cover object-center"
                        />
                    </div>
                    <div class="flex flex-col gap-1">
                        <p class="font-semibold style-body-bold">{{ package_booking.tour.name }}</p>
                        <div class="flex gap-1 items-center">
                            <div class="w-4 h-">
                                <img src="/icons/small/calendar-grey.svg" alt="icon" class="w-4 h-4" />
                            </div>
                            <span class="text-custom-gray-dark style-body">{{ package_booking.date_range }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex flex-col gap-3 px-4">
                <p class="font-semibold">Payment Transfer to</p>
                <div class="bg-white p-[16px_24px] rounded-[26px] flex flex-col gap-4">
                    <div class="flex flex-col gap-1">
                        <p class="text-custom-gray-dark style-body">Bank Name</p>
                        <div class="flex items-center gap-2">
                            <div class="w-[35px] h-[25px] flex shrink-0 overflow-hidden">
                                <img
                                    :src="package_booking.bank.logo_url"
                                    class="w-full h-full object-contain object-center"
                                    alt="logo"
                                />
                            </div>
                            <span class="style-body">{{ package_booking.bank.bank_name }}</span>
                        </div>
                    </div>
                    <div class="flex flex-col gap-1">
                        <p class="text-custom-gray-dark style-body">Bank Account</p>
                        <div class="flex items-center gap-2">
                            <div class="w-[35px] h-[25px] flex shrink-0 overflow-hidden">
                                <img
                                    src="/icons/medium/bank.svg"
                                    class="w-full h-full object-contain object-center"
                                    alt="logo"
                                />
                            </div>
                            <span class="style-body">PT Glidetrip Sejahtera</span>
                        </div>
                    </div>
                    <div class="flex flex-col gap-1">
                        <p class="text-custom-gray-dark style-body">Account Number</p>
                        <div class="flex items-center gap-2">
                            <div class="w-[35px] h-[25px] flex shrink-0 overflow-hidden">
                                <img
                                    src="/icons/medium/moneys.svg"
                                    class="w-full h-full object-contain object-center"
                                    alt="logo"
                                />
                            </div>
                            <span class="style-body">987364528</span>
                            <Button
                                size="small"
                                state="tertiary"
                                text="Copy"
                                @click="copyText(987364528)"
                                class="ml-auto font-semibold h-0"
                            />
                        </div>
                    </div>
                    <hr />
                    <div class="flex flex-col gap-1">
                        <p class="text-custom-gray-dark style-body">Total Payment</p>
                        <div class="flex items-center gap-2">
                            <span class="text-xl font-semibold tracking-wide">{{
                                formatCurrency(package_booking.total_amount)
                            }}</span>
                            <Button
                                size="small"
                                state="tertiary"
                                text="Copy"
                                @click="copyText(package_booking.total_amount)"
                                class="ml-auto font-semibold h-0"
                            />
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex flex-col gap-3 px-4">
                <div class="flex flex-col gap-1">
                    <p class="font-semibold">Transfer Proof</p>
                    <p class="text-custom-gray-dark style-caption">
                        After you make the transfer, please upload your proof of payment to confirm transaction.
                    </p>
                </div>
                <div class="flex items-center gap-3">
                    <button
                        type="button"
                        id="upload-file"
                        class="bg-white border border-custom-gray-200 p-[16px_0_16px_12px] rounded-[10px] overflow-hidden w-full"
                        @click="triggerFileInput"
                    >
                        <p
                            v-if="!fileName"
                            id="placeholder"
                            class="text-nowrap text-custom-gray-dark style-body text-left"
                        >
                            Upload transfer proof
                        </p>
                        <div v-else id="file-info" class="flex flex-row flex-nowrap gap-3 items-center">
                            <div class="w-6 h-6 flex shrink-0">
                                <img src="/icons/small/gallery.svg" alt="icon" />
                            </div>
                            <span id="fileName" class="text-sm text-nowrap">{{ fileName }}</span>
                        </div>
                    </button>
                    <input
                        type="file"
                        ref="fileInput"
                        name="proof"
                        id="file"
                        class="hidden"
                        accept="image/*"
                        @change="handleFileChange"
                    />
                </div>
                <div
                    class="w-full h-[88px] bg-blue overflow-hidden flex items-center shrink-0 mx-auto rounded-2xl relative"
                >
                    <img src="/images/Claim-Reward.png" class="object-contain w-full h-full" alt="rewards" />
                </div>
            </div>
            <div
                class="navigation-bar fixed bottom-0 z-50 max-w-[640px] w-full h-[85px] bg-black rounded-t-[25px] flex items-center justify-between px-6"
            >
                <div class="flex flex-col gap-1 justify-center">
                    <p class="text-white style-subheadline">Total Payment</p>
                    <p class="font-semibold text-xl leading-[26px] tracking-[0.6px] text-custom-yellow">
                        {{ formatCurrency(package_booking.total_amount) }}
                    </p>
                </div>
                <Button
                    size="small"
                    :state="buttonState"
                    text="Confirm"
                    class="text-[16px] font-normal leading-[24px] tracking-[0px]"
                    @click="handleSubmit"
                />
            </div>
        </form>
    </section>
</template>
