<script setup>
import { ref } from 'vue';
import { usePage, Head, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const page = usePage();
const form = useForm({});
const roles = page.props.roles || [];
const isSuperAdmin = roles.includes('super_admin');
const package_tour = ref(page.props.package_tour || { data: [], links: [] });
const latestPhotos = ref(page.props.latestPhotos || { data: [], links: [] });

const deleteTour = async (tourId) => {
    if (confirm('Are you sure you want to delete this package tour?')) {
        form.delete(route('admin.package_tours.destroy', { package_tour: tourId }), {
            onSuccess: () => {
                package_tour.value.data = package_tour.value.data.filter((package_tour) => package_tour.id !== tourId);
            }
        });
    }
};
</script>

<template>
    <Head title="Details Package Tour" />

    <AuthenticatedLayout :is-super-admin="isSuperAdmin">
        <template #header>
            <div class="flex flex-row justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Details Package Tours</h2>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-10 flex flex-col gap-y-5">
                    <div>
                        <div class="item-card flex flex-row justify-between items-center mb-4">
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
                                    :href="route('admin.package_tours.edit', { package_tour: package_tour.id })"
                                    class="font-bold py-4 px-6 bg-indigo-700 text-white rounded-full"
                                >
                                    Edit
                                </a>
                                <form @submit.prevent="deleteTour(package_tour.id)">
                                    <button
                                        type="submit"
                                        class="font-bold py-4 px-6 bg-red-700 text-white rounded-full"
                                    >
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <hr class="my-5" />
                    <h3 class="text-indigo-950 text-xl font-bold">Gallery Photos</h3>

                    <div v-if="latestPhotos.length < 1">
                        <p>Belum ada foto terbaru</p>
                    </div>

                    <div v-else class="flex flex-row gap-x-5">
                        <img
                            v-for="(latestPhoto, i) in latestPhotos"
                            :key="i"
                            :src="latestPhoto.photo_url"
                            :alt="'photo ' + i"
                            class="rounded-2xl object-cover w-[120px] h-[90px]"
                        />
                    </div>
                    <div>
                        <h3 class="text-indigo-950 text-xl font-bold">About</h3>
                        <p>
                            {{ package_tour.about }}
                        </p>
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
