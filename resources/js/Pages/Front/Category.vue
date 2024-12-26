<script setup>
import { ref, onMounted } from 'vue';
import { Head, usePage, Link } from '@inertiajs/vue3';
import Navigation from '@/Components/Navigation.vue';

const page = usePage();
const category = page.props.category || [];
</script>

<template>
    <Head title="Category" />
    <section class="max-w-[640px] w-full mx-auto bg-custom-background min-h-screen flex flex-col gap-8 pb-[120px]">
        <Navigation :text="category.name" />
        <div class="flex flex-col gap-3 px-4">
            <h1 v-if="category.tours.length == 0" class="style-title text-custom-gray-dark text-center">
                There is no trip in this category
            </h1>
            <Link
                v-for="package_tour in category.tours"
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
    </section>
</template>
