<script setup>
import { ref } from 'vue';
import { usePage, Head, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const page = usePage();
const form = useForm({});
const roles = page.props.roles || [];
const isSuperAdmin = roles.includes('super_admin');
const package_tours = ref(page.props.package_tours || { data: [], links: [] });
</script>

<template>
    <Head title="Package Tour" />

    <AuthenticatedLayout :is-super-admin="isSuperAdmin">
        <template #header>
            <div class="flex flex-row justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Manage Package Tours</h2>
                <a
                    :href="route('admin.package_tours.create')"
                    class="font-bold py-4 px-6 bg-indigo-700 text-white rounded-full"
                >
                    Add New
                </a>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-10 flex flex-col gap-y-5">
                    <div v-if="package_tours.data.length === 0" class="text-center text-gray-500">
                        No Package Tour available.
                    </div>

                    <div v-else>
                        <div
                            v-for="package_tour in package_tours.data"
                            :key="package_tour.id"
                            class="item-card flex flex-row justify-between items-center mb-4"
                        >
                            <div class="flex flex-row items-center gap-x-3">
                                <img
                                    :src="package_tour.thumbnail_url"
                                    :alt="package_tour.name + ' image'"
                                    class="rounded-2xl object-cover w-[90px] h-[90px]"
                                />
                                <div class="flex flex-col">
                                    <h3 class="text-indigo-950 text-xl font-bold">{{ package_tour.name }}</h3>
                                    <p class="text-slate-500 text-sm">{{ package_tour.category.name }}</p>
                                </div>
                            </div>
                            <div class="hidden md:flex flex-col">
                                <p class="text-slate-500 text-sm">Price</p>
                                <h3 class="text-indigo-950 text-xl font-bold">
                                    {{ package_tour.formatted_price }}
                                </h3>
                            </div>
                            <div class="hidden md:flex flex-col">
                                <p class="text-slate-500 text-sm">Total Days</p>
                                <h3 class="text-indigo-950 text-xl font-bold">{{ package_tour.days }} Days</h3>
                            </div>
                            <div class="hidden md:flex flex-row items-center gap-x-3">
                                <a
                                    :href="route('admin.package_tours.show', { package_tour: package_tour.id })"
                                    class="font-bold py-4 px-6 bg-indigo-700 text-white rounded-full"
                                >
                                    Manage
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
.item-card {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 1rem;
}
</style>
