<script setup>
import { Head, usePage, Link, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const page = usePage();
const form = useForm({
    _method: 'patch'
});
const roles = page.props.roles || [];
const isSuperAdmin = roles.includes('super_admin');
const packageBooking = page.props.packageBooking || [];

const formatCurrency = (value) => {
    value = parseFloat(value);
    return `Rp ${value.toLocaleString('id-ID')}`;
};
const handleApprove = () => {
    form.post(route('admin.package_bookings.update', packageBooking.id));
};
</script>
<template>
    <Head title="Booking Details" />
    <AuthenticatedLayout :is-super-admin="isSuperAdmin">
        <template #header>
            <div class="flex flex-row justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Details Bookings</h2>
            </div>
        </template>
        <div class="py-12">
            <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-10 flex flex-col gap-y-5">
                    <div class="item-card flex flex-row justify-between items-center">
                        <div class="flex flex-row items-center gap-x-3">
                            <img
                                :src="packageBooking.tour.thumbnail_url"
                                alt="thumbnail"
                                class="rounded-2xl object-cover w-[120px] h-[90px]"
                            />
                            <div class="flex flex-col">
                                <h3 class="text-indigo-950 style-title">{{ packageBooking.tour.name }}</h3>
                                <p class="text-slate-500 text-sm">{{ packageBooking.tour.category.name }}</p>
                            </div>
                        </div>
                        <span
                            v-if="packageBooking.is_paid"
                            class="w-fit text-sm font-bold py-2 px-3 rounded-full bg-green-500 text-white"
                        >
                            SUCCESS
                        </span>

                        <span v-else class="w-fit text-sm font-bold py-2 px-3 rounded-full bg-orange-500 text-white">
                            PENDING
                        </span>
                        <button
                            @click="handleApprove"
                            v-show="!packageBooking.is_paid"
                            class="font-bold py-4 px-6 bg-indigo-700 text-white rounded-full"
                        >
                            Approve Transaction
                        </button>
                    </div>

                    <hr class="my-5" />

                    <div class="grid grid-cols-2 gap-5">
                        <div class="flex flex-col gap-y-4">
                            <div class="flex flex-col">
                                <p class="text-slate-500 text-sm">Name</p>
                                <h3 class="text-indigo-950 text-xl font-bold">{{ packageBooking.customer.name }}</h3>
                            </div>
                            <div class="flex flex-col">
                                <p class="text-slate-500 text-sm">Email</p>
                                <h3 class="text-indigo-950 text-xl font-bold">{{ packageBooking.customer.email }}</h3>
                            </div>
                            <div class="flex flex-col">
                                <p class="text-slate-500 text-sm">Phone</p>
                                <h3 class="text-indigo-950 text-xl font-bold">
                                    {{ packageBooking.customer.phone_number }}
                                </h3>
                            </div>
                        </div>
                        <div class="flex flex-col gap-y-4">
                            <div class="flex flex-col">
                                <p class="text-slate-500 text-sm">Quantity</p>
                                <h3 class="text-indigo-950 text-xl font-bold">{{ packageBooking.quantity }} people</h3>
                            </div>
                            <div class="flex flex-col">
                                <p class="text-slate-500 text-sm">Total Days</p>
                                <h3 class="text-indigo-950 text-xl font-bold">{{ packageBooking.tour.days }} days</h3>
                            </div>
                            <div class="flex flex-col">
                                <p class="text-slate-500 text-sm">Date</p>
                                <h3 class="text-indigo-950 text-xl font-bold">
                                    {{ packageBooking.formatted_start_date }} -
                                    {{ packageBooking.formatted_end_date }}
                                </h3>
                            </div>
                        </div>
                    </div>

                    <hr class="my-5" />

                    <div class="grid grid-cols-2 gap-5">
                        <div class="flex flex-col gap-y-4">
                            <div class="flex flex-col">
                                <p class="text-slate-500 text-sm">Sub Total</p>
                                <h3 class="text-indigo-950 text-xl font-bold">
                                    {{ formatCurrency(packageBooking.subtotal) }}
                                </h3>
                            </div>
                            <div class="flex flex-col">
                                <p class="text-slate-500 text-sm">Insurance</p>
                                <h3 class="text-indigo-950 text-xl font-bold">
                                    {{ formatCurrency(packageBooking.insurance) }}
                                </h3>
                            </div>
                            <div class="flex flex-col">
                                <p class="text-slate-500 text-sm">Tax (11%)</p>
                                <h3 class="text-indigo-950 text-xl font-bold">
                                    {{ formatCurrency(packageBooking.tax) }}
                                </h3>
                            </div>
                            <div class="flex flex-col">
                                <p class="text-slate-500 text-sm">Total Amount</p>
                                <h3 class="text-indigo-950 text-xl font-bold">
                                    {{ formatCurrency(packageBooking.total_amount) }}
                                </h3>
                            </div>
                        </div>
                        <div class="flex flex-col gap-y-4">
                            <h3 class="text-indigo-950 text-xl font-bold">Bukti Pembayaran</h3>

                            <img
                                :src="packageBooking.proof_url"
                                alt="proof"
                                class="rounded-2xl object-cover w-[300px] h-[200px]"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
