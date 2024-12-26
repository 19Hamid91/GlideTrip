<script setup>
import Flickity from 'flickity';
import { ref, onMounted } from 'vue';
import { Head, usePage, Link } from '@inertiajs/vue3';
import NavBottom from '@/Components/NavBottom.vue';

const page = usePage();
const categories = page.props.categories || [];
const package_tours = page.props.package_tours || [];

const categoryContainer = ref(null);
const recommendationContainer = ref(null);

onMounted(() => {
    new Flickity(categoryContainer.value, {
        cellAlign: 'left',
        contain: true,
        prevNextButtons: false,
        pageDots: false,
        wrapAround: false
    });
    new Flickity(recommendationContainer.value, {
        cellAlign: 'left',
        contain: true,
        prevNextButtons: false,
        pageDots: false,
        wrapAround: false
    });
});
</script>

<template>
    <Head title="Home" />
    <section
        id="content"
        class="max-w-[640px] w-full mx-auto bg-custom-background min-h-screen flex flex-col gap-8 pb-[120px]"
    >
        <nav class="mt-8 px-4 w-full flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div
                    class="w-12 h-12 border-4 border-white rounded-full overflow-hidden flex shrink-0 shadow-[6px_8px_wopx_0_#00000008]"
                >
                    <img class="w-full h-full object-cover object-center" src="/photos/pfp.png" alt="Photo" />
                </div>
                <div class="flex flex-col gap-1">
                    <p class="text-custom-black style-caption">Welcome!</p>
                    <p class="text-custom-black style-title">Pitik Slayer</p>
                </div>
            </div>
            <a href="/">
                <div
                    class="w-12 h-12 rounded-full bg-white overflow-hidden flex shrink-0 items-center justify-center shadow-[6px_8px_20px_0_#00000008]"
                >
                    <img
                        class="w-6 h-6 object-cover object-center fill-custom-blue"
                        src="/icons/small/notification.svg"
                        alt="Notification"
                    />
                </div>
            </a>
        </nav>
        <h1 class="style-headline text-center">Explore New<br />Experience with Us</h1>
        <div id="categories" class="flex flex-col gap-3">
            <h2 class="font-semibold px-4">Categories</h2>
            <div ref="categoryContainer" class="main-carousel buttons-container">
                <Link
                    v-for="category in categories"
                    :href="route('front.category', category.slug)"
                    :key="category.id"
                    class="group px-2 first-of-type:pl-4 last-of-type:pr-4 carousel-cell"
                >
                    <div
                        class="p-3 flex items-center gap-2 rounded-[10px] border border-custom-blue group-hover:bg-custom-blue transition-all duration-300"
                    >
                        <div class="w-6 h-6 flex shrink-0">
                            <img :src="category.icon_url" alt="icon" />
                        </div>
                        <span
                            class="text-sm tracking-[0.35px] text-custom-blue border-custom-blue group-hover:text-white transition-all duration-300"
                        >
                            {{ category.name }}
                        </span>
                    </div>
                </Link>
            </div>
        </div>
        <div id="recommendations" class="flex flex-col gap-3">
            <h2 class="font-semibold px-4">Trip Recommendation</h2>
            <div ref="recommendationContainer" class="main-carousel card-container">
                <Link
                    v-for="package_tour in package_tours"
                    :key="package_tour.id"
                    :href="route('front.details', package_tour.slug)"
                    class="group px-2 firstof_type:pl-4 last-of-type:pr-4"
                >
                    <div
                        class="w-[288px] p-4 flex flex-col gap-3 rounded-[26px] bg-white shadow-[6px_8px_20px_0_#00000008]"
                    >
                        <div class="w-full h-[330px] rounded-xl flex shrink-0 overflow-hidden">
                            <img :src="package_tour.thumbnail_url" class="w-full h-full object-cover" alt="thumbnail" />
                        </div>
                        <div class="flex justify-between gap-2">
                            <div class="flex flex-col gap-1">
                                <p class="font-semibold two-lines">{{ package_tour.name }}</p>
                                <div class="flex items-center gap-1">
                                    <div class="w-4 h-4 flex shrink-0">
                                        <img src="/icons/small/location-map.svg" alt="icon" />
                                    </div>
                                    <span class="text-custom-gray-dark style-body">{{ package_tour.location }}</span>
                                </div>
                            </div>
                            <div class="flex flex-col gap-1 text-right">
                                <p class="style-body">
                                    <span class="font-semibold text-custom-blue text-nowrap">{{
                                        package_tour.formatted_price
                                    }}</span
                                    ><br />
                                    <span class="text-custom-gray-dark">/{{ package_tour.days }}days</span>
                                </p>
                                <div class="flex items-center gap-1 justify-end">
                                    <div class="w-4 h-4 flex shrink-0">
                                        <img src="/icons/small/magic-star.svg" alt="icon" />
                                    </div>
                                    <span class="font-semibold style-body">4.8</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </Link>
            </div>
        </div>
        <div id="discover" class="px-4">
            <div class="w-full h-[130px] flex flex-col gap-[10px] rounded-[22px] items-center overflow-hidden relative">
                <img src="/images/Banner.png" alt="banner" class="w-full h-full object-cover object-center" />
                <div class="absolute z-10 flex flex-col gap-[10px] trasform -translate-y-1/2 top-1/2 left-4">
                    <p class="text-white style-highlight">Discover the<br />Beauty of Japan</p>
                    <a href="" class="bg-custom-blue p-[8px_24px] rounded-[10px] text-white style-caption-bold w-fit"
                        >Discover</a
                    >
                </div>
            </div>
        </div>
        <div id="explore" class="flex flex-col px-4 gap-3">
            <h2 class="font-semibold">More to Explore</h2>
            <a
                v-for="package_tour in package_tours"
                :key="package_tour.id"
                :href="route('front.details', package_tour.slug)"
                class="card"
            >
                <div class="w-full p-4 flex flex-col gap-3 rounded-[26px] bg-white shadow-[6px_8px_20px_0_#00000008]">
                    <div class="w-full h-full aspect-[311/150] rounded-xl overflow-hidden">
                        <img
                            :src="package_tour.thumbnail_url"
                            class="w-full h-full object-cover object-center"
                            alt="thumbnail"
                        />
                    </div>
                    <div class="flex justify-between gap-2">
                        <div class="flex flex-col gap-1">
                            <p class="font-semibold two-lines">{{ package_tour.name }}</p>
                            <div class="flex items-center gap-1">
                                <div class="w-4 h-4 flex shrink-0">
                                    <img src="/icons/small/location-map.svg" alt="icon" />
                                </div>
                                <span class="text-custom-gray-dark style-body">{{ package_tour.location }}</span>
                            </div>
                        </div>
                        <div class="flex flex-col gap-1 text-right">
                            <p class="style-body">
                                <span class="font-semibold text-custom-blue text-nowrap">{{
                                    package_tour.formatted_price
                                }}</span
                                ><br />
                                <span class="text-custom-gray-dark">/{{ package_tour.days }}days</span>
                            </p>
                            <div class="flex items-center gap-1 justify-end">
                                <div class="w-4 h-4 flex shrink-0">
                                    <img src="/icons/small/magic-star.svg" alt="icon" />
                                </div>
                                <span class="font-semibold style-body">4.8</span>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <NavBottom />
    </section>
</template>
