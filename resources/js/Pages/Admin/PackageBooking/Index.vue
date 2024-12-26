<script setup>
import { usePage, Head, Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const page = usePage();
const roles = page.props.roles || [];
const isSuperAdmin = roles.includes('super_admin');
const bookings = page.props.bookings || [];

const formatCurrency = (value) => {
    value = parseFloat(value);
    return `Rp ${value.toLocaleString('id-ID')}`;
};
</script>
<template>
    <Head title="Bookings" />
    <AuthenticatedLayout :is-super-admin="isSuperAdmin">
        <template #header>
            <div class="flex flex-row justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Manage Bookings</h2>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-10 flex flex-col gap-y-5">
                    <div v-if="bookings.length === 0" class="text-center text-gray-500">No bookings available.</div>

                    <div v-else>
                        <div
                            v-for="booking in bookings"
                            :key="booking.id"
                            class="item-card flex flex-row justify-between items-center mb-4"
                        >
                            <div class="flex flex-row items-center gap-x-3">
                                <img
                                    :src="booking.tour.thumbnail_url"
                                    alt="thumbnail"
                                    class="rounded-2xl object-cover w-[90px] h-[90px]"
                                />
                                <div class="flex flex-col">
                                    <h3 class="text-indigo-950 text-xl font-bold">{{ booking.tour.name }}</h3>
                                    <p class="style-caption text-custom-gray-dark">{{ booking.tour.category.name }}</p>
                                </div>
                            </div>
                            <div class="hidden md:flex flex-col">
                                <span
                                    v-if="booking.is_paid"
                                    class="w-fit text-sm font-bold py-2 px-3 rounded-full bg-green-500 text-white"
                                >
                                    SUCCESS
                                </span>

                                <span
                                    v-else
                                    class="w-fit text-sm font-bold py-2 px-3 rounded-full bg-orange-500 text-white"
                                >
                                    PENDING
                                </span>
                            </div>
                            <div class="hidden md:flex flex-col">
                                <p class="text-slate-500 text-sm">Price</p>
                                <h3 class="text-indigo-950 text-xl font-bold">
                                    {{ formatCurrency(booking.total_amount) }}
                                </h3>
                            </div>
                            <div class="hidden md:flex flex-col">
                                <p class="text-slate-500 text-sm">Total Days</p>
                                <h3 class="text-indigo-950 text-xl font-bold">{{ booking.tour.days }} Days</h3>
                            </div>
                            <div class="hidden md:flex flex-col">
                                <p class="text-slate-500 text-sm">Quantity</p>
                                <h3 class="text-indigo-950 text-xl font-bold">{{ booking.quantity }} People</h3>
                            </div>
                            <div class="hidden md:flex flex-row items-center gap-x-3">
                                <Link
                                    :href="route('admin.package_bookings.show', booking.id)"
                                    class="font-bold py-4 px-6 bg-indigo-700 text-white rounded-full"
                                >
                                    Details
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
