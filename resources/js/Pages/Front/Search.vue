<script setup>
import { Head, usePage, Link } from '@inertiajs/vue3';
import axios from 'axios';
import { ref } from 'vue';
import Navigation from '@/Components/Navigation.vue';
import NavBottom from '@/Components/NavBottom.vue';

const page = usePage();
const package_tours = ref(page.props.package_tours || []);
const searchQuery = ref('');
let debounceTimeout = null;

const fetchPackageTours = async () => {
    try {
        const response = await axios.get(route('front.search'), {
            params: { search: searchQuery.value }
        });
        package_tours.value = response.data;
        console.log(package_tours);
    } catch (error) {
        console.error('Error fetching package tours:', error);
    }
};

const debounceFetchPackageTours = () => {
    clearTimeout(debounceTimeout);
    debounceTimeout = setTimeout(() => {
        fetchPackageTours();
    }, 500);
};
</script>

<template>
    <Head title="Search" />
    <section class="max-w-[640px] w-full mx-auto bg-custom-background min-h-screen flex flex-col gap-8 pb-[120px]">
        <Navigation text="Search" />
        <div class="flex flex-col gap-3 px-4">
            <div class="flex items-center gap-[10px] bg-white p-[16px_24px] rounded-[37px] transition-all duration-300">
                <input
                    type="text"
                    name="search"
                    required
                    v-model="searchQuery"
                    @input="debounceFetchPackageTours"
                    placeholder="Search trip..."
                    class="appearance-none outline-none w-full relative text-sm tracking-035 leading-[22px] [&::-webkit-calendar-picker-indicator]:absolute [&::-webkit-calendar-picker-indicator]:w-full [&::-webkit-calendar-picker-indicator]:h-full [&::-webkit-calendar-picker-indicator]:opacity-0 custom-appearance-none"
                />
                <div class="w-6 h-6 flex shrink-0">
                    <img src="/icons/small/search.svg" class="w-full h-full" alt="icon" />
                </div>
            </div>
            <h1 v-if="package_tours.length == 0" class="style-title text-custom-gray-dark text-center mt-8">
                Trip not found
            </h1>
            <Link
                v-for="package_tour in package_tours"
                :key="package_tour.id"
                :href="route('front.details', package_tour.slug)"
                class="card"
            >
                <div class="bg-white p-4 rounded-[26px] flex flex-col gap-3">
                    <div class="flex items-center gap-4">
                        <div class="w-[92px] h-[92px] flex shrink-0 rounded-xl overflow-hidden">
                            <img :src="package_tour.thumbnail_url" alt="thumbnail" />
                        </div>
                        <div class="flex flex-col gap-1">
                            <p class="font-semibold two-lines">{{ package_tour.name }}</p>
                            <div class="flex items-center gap-1">
                                <div class="w-4 h-4 flex shrink-0">
                                    <img src="/icons/small/location-map.svg" alt="icon" />
                                </div>
                                <span class="style-body text-custom-gray-dark">{{ package_tour.location }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-between items-center">
                        <div class="flex items-center gap-2">
                            <span class="style-body-bold">4.8</span>
                            <div class="flex items-center gap-1">
                                <img src="/icons/small/magic-star.svg" alt="star" />
                                <img src="/icons/small/magic-star.svg" alt="star" />
                                <img src="/icons/small/magic-star.svg" alt="star" />
                                <img src="/icons/small/magic-star.svg" alt="star" />
                                <img src="/icons/small/magic-star-gray.svg" alt="star" />
                            </div>
                        </div>
                        <p class="style-body">
                            <span class="font-semibold text-custom-blue text-nowrap">{{
                                package_tour.formatted_price
                            }}</span>
                            <span class="text-custom-gray-dark">/{{ package_tour.days }}days</span>
                        </p>
                    </div>
                </div>
            </Link>
        </div>
        <NavBottom active="search" />
    </section>
</template>
