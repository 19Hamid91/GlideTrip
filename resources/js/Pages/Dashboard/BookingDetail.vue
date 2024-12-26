<script setup>
import { Head, usePage } from '@inertiajs/vue3';
import Navigation from '@/Components/Navigation.vue';
import Badge from '@/Components/Badge.vue';
import Button from '@/Components/Button.vue';

const page = usePage();
const user = page.props.auth.user;
const package_booking = page.props.packageBooking || [];

const formatCurrency = (value) => {
    value = parseFloat(value);
    return `Rp ${value.toLocaleString('id-ID')}`;
};
</script>
<template>
    <Head title="Booking Detail" />
    <section
        id="content"
        class="flex flex-col max-w-[640px] w-full min-h-screen mx-auto bg-custom-background gap-8 pb-[120px]"
    >
        <Navigation text="Trip Details" />
        <div class="flex flex-col gap-8">
            <div class="flex flex-col gap-3 px-4">
                <p class="font-semibold">Detail Trip</p>
                <div class="bg-white p-4 rounded-[26px] flex items-center gap-3">
                    <div class="w-[72px] h-[72px] flex shrink-0 rounded-xl overflow-hidden">
                        <img :src="package_booking.tour.thumbnail_url" alt="thumbnail" />
                    </div>
                    <div class="flex flex-col gap-1">
                        <p class="style-body-bold two-lines">{{ package_booking.tour.name }}</p>
                        <div class="flex items-center gap-1">
                            <div class="w-4 h-4">
                                <img src="/icons/small/calendar-grey.svg" alt="icon" class="w-4 h-4" />
                            </div>
                            <span class="style-body text-custom-gray-dark"
                                >{{ package_booking.formatted_start_date }} -
                                {{ package_booking.formatted_end_date }}</span
                            >
                        </div>
                        <Badge v-show="package_booking.is_paid" text="Success Paid" />
                    </div>
                </div>
            </div>
            <div class="flex flex-col gap-3 px-4">
                <p class="font-semibold">Contact Details</p>
                <div class="bg-white p-[16px_24px] rounded-[26px] flex flex-col gap-3">
                    <div class="flex justify-between items-center style-body">
                        <p>Name</p>
                        <p class="font-semibold">{{ user.name }}</p>
                    </div>
                    <div class="flex justify-between items-center style-body">
                        <p>Email</p>
                        <p class="font-semibold">{{ user.email }}</p>
                    </div>
                    <div class="flex justify-between items-center style-body">
                        <p>Phone</p>
                        <p class="font-semibold">{{ user.phone_number }}</p>
                    </div>
                </div>
            </div>
            <div class="flex flex-col gap-3 px-4">
                <p class="font-semibold">Payment Summary</p>
                <div class="bg-white p-[16px_24px] rounded-[26px] flex flex-col gap-3">
                    <div class="flex justify-between items-center style-body">
                        <p>Sub Total</p>
                        <p class="font-semibold text-custom-blue">{{ formatCurrency(package_booking.subtotal) }}</p>
                    </div>
                    <div class="flex justify-between items-center style-body">
                        <p>
                            Insurance <span class="text-custom-gray-dark">x{{ quantity }}</span>
                        </p>
                        <p class="font-semibold text-custom-blue">{{ formatCurrency(package_booking.insurance) }}</p>
                    </div>
                    <div class="flex justify-between items-center style-body">
                        <p>Tax 11%</p>
                        <p class="font-semibold text-custom-blue">{{ formatCurrency(package_booking.tax) }}</p>
                    </div>
                    <hr />
                    <div class="flex justify-between items-center style-body">
                        <p>Total Payment</p>
                        <p class="text-xl font-semibold">
                            {{ formatCurrency(package_booking.total_amount) }}
                        </p>
                    </div>
                </div>
            </div>
            <div class="flex flex-col gap-3 px-4">
                <Button
                    size="medium"
                    class="w-full mx-auto"
                    text="Contact Travel Agent"
                    icon="/icons/medium/messages.svg"
                />
            </div>
        </div>
    </section>
</template>
