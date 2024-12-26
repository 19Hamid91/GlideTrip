<script setup>
import { ref } from 'vue';
import Navigation from '@/Components/Navigation.vue';
import { Head, usePage, Link } from '@inertiajs/vue3';
import Button from '@/Components/Button.vue';

// State
const page = usePage();
const package_tour = page.props.package_tour || [];
const imageThumbnail = ref(null);
const activeThumbnail = ref(package_tour.thumbnail_url);
const isCollapsed = ref(true);

// Methods
const toggleReadMore = () => {
    isCollapsed.value = !isCollapsed.value;
};

const updateThumbnail = (event, photoUrl) => {
    event.preventDefault();
    imageThumbnail.value.src = photoUrl;
    activeThumbnail.value = photoUrl;
};
</script>

<template>
    <Head title="details" />
    <section
        id="content"
        class="max-w-[640px] w-full mx-auto bg-custom-background min-h-screen flex flex-col gap-8 pb-[80px]"
    >
        <Navigation text="Details" :trailIcon="true" />

        <div id="image-details" class="px-4 flex flex-col gap-3">
            <div class="w-full h-[345px] flex shrink-0 rounded-xl overflow-hidden">
                <img
                    ref="imageThumbnail"
                    :src="package_tour.thumbnail_url"
                    class="w-full h-full object-cover object-center"
                    alt="thumbnail"
                    id="image-thumbnail"
                />
            </div>
            <div class="grid grid-cols-4 gap-4 w-fit mx-auto">
                <a
                    :key="0"
                    :href="package_tour.thumbnail_url"
                    class="thumbnail-option w-[74px] h-[74px] flex shrink-0 rounded-xl border-2 overflow-hidden mx-auto"
                    @click="updateThumbnail($event, package_tour.thumbnail_url)"
                    :class="{
                        'opacity-50': activeThumbnail !== package_tour.thumbnail_url,
                        'border-custom-blue': activeThumbnail === package_tour.thumbnail_url
                    }"
                >
                    <img
                        :src="package_tour.thumbnail_url"
                        alt="photo"
                        class="w-full h-full object-cover object-center"
                    />
                </a>
                <a
                    v-for="photo in package_tour.package_photos"
                    :key="photo.id"
                    :href="photo.photo_url"
                    class="thumbnail-option w-[74px] h-[74px] flex shrink-0 rounded-xl border-2 overflow-hidden mx-auto"
                    @click="updateThumbnail($event, photo.photo_url)"
                    :class="{
                        'opacity-50': activeThumbnail !== photo.photo_url,
                        'border-custom-blue': activeThumbnail === photo.photo_url
                    }"
                >
                    <img :src="photo.photo_url" alt="photo" class="w-full h-full object-cover object-center" />
                </a>
            </div>
        </div>
        <div class="mx-4 flex flex-col gap-3 bg-white p-[16px_24px] rounded-[22px]">
            <h1 class="font-semibold">{{ package_tour.name }}</h1>
            <div class="flex justify-between gap-2">
                <div class="flex items-center gap-2">
                    <div class="w-6 h-6 flex items-center shrink-0">
                        <img src="/icons/small/location-map.svg" alt="icon" class="w-full h-full object-contain" />
                    </div>
                    <div class="flex flex-col gap-1">
                        <p class="style-body text-custom-gray-dark">Location</p>
                        <p class="style-body-bold">{{ package_tour.location }}</p>
                    </div>
                </div>
                <div class="flex flex-col gap-1">
                    <p class="style-body text-custom-gray-dark">Rating</p>
                    <div class="flex items-center gap-2">
                        <span class="style-body-bold">4.8</span>
                        <div class="flex items-center gap-1">
                            <img src="/icons/small/magic-star.svg" alt="icon" />
                            <img src="/icons/small/magic-star.svg" alt="icon" />
                            <img src="/icons/small/magic-star.svg" alt="icon" />
                            <img src="/icons/small/magic-star.svg" alt="icon" />
                            <img src="/icons/small/magic-star-gray.svg" alt="icon" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mx-4 flex flex-col gap-3 bg-white p-[16px_24px] rounded-[22px]">
            <h2 class="font-semibold">About Destination</h2>
            <p v-if="isCollapsed" id="readMore" class="style-body text-custom-gray-dark">
                {{ package_tour.truncated_about }}
                <button @click="toggleReadMore" class="font-semibold text-custom-blue">Read More</button>
            </p>
            <p v-else id="seeLess" class="style-body text-custom-gray-dark">
                {{ package_tour.about }}
                <button @click="toggleReadMore" class="font-semibold text-custom-blue">See Less</button>
            </p>
        </div>
        <div class="mx-4 flex flex-col gap-3 bg-white p-[16px_24px] rounded-[22px]">
            <h2 class="font-semibold">Testimonial</h2>
            <div class="flex flex-col gap-1">
                <div class="flex items-center justify-between gap-2">
                    <div class="flex items-center gap-1">
                        <div
                            class="w-12 h-12 border-4 border-white rounded-full overflow-hidden flex shrink-0 shadow-[6px_8px_20px_0_#00000008]"
                        >
                            <img src="/photos/pfp.png" alt="photo" />
                        </div>
                        <div class="flex flex-col gap-1">
                            <p class="style-body-bold">James Sullivan</p>
                            <p class="style-caption text-custom-gray-dark">1 week ago</p>
                        </div>
                    </div>
                    <div class="flex gap-1 items-center">
                        <img src="/icons/small/magic-star.svg" alt="icon" />
                        <img src="/icons/small/magic-star.svg" alt="icon" />
                        <img src="/icons/small/magic-star.svg" alt="icon" />
                        <img src="/icons/small/magic-star.svg" alt="icon" />
                        <img src="/icons/small/magic-star.svg" alt="icon" />
                    </div>
                </div>
                <p class="style-body text-custom-gray-dark">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Obcaecati nisi ullam neque nemo ut at a
                    eligendi placeat. Omnis, officia!
                </p>
            </div>
            <hr />
            <div class="flex gap-4">
                <div class="flex flex-col gap-3">
                    <p class="font-semibold">2.547 <span class="style-body text-custom-gray-dark">Reviews</span></p>
                    <div class="flex items-center">
                        <div
                            class="w-12 h-12 border-4 border-white rounded-full overflow-hidden flex shrink-0 shadow-[6px_8px_20px_0_#00000008] -ml-2 first-of-type:-ml-1"
                        >
                            <img src="/photos/pfp.png" alt="photo" class="w-full h-full object-cover object-center" />
                        </div>
                        <div
                            class="w-12 h-12 border-4 border-white rounded-full overflow-hidden flex shrink-0 shadow-[6px_8px_20px_0_#00000008] -ml-2 first-of-type:-ml-1"
                        >
                            <img src="/photos/pfp2.png" alt="photo" class="w-full h-full object-cover object-center" />
                        </div>
                        <div
                            class="w-12 h-12 border-4 border-white rounded-full overflow-hidden flex shrink-0 shadow-[6px_8px_20px_0_#00000008] -ml-2 first-of-type:-ml-1"
                        >
                            <img src="/photos/pfp3.png" alt="photo" class="w-full h-full object-cover object-center" />
                        </div>
                    </div>
                </div>
                <div class="flex flex-col gap-3">
                    <p class="font-semibold">Photo & Video</p>
                    <div class="flex gap-1">
                        <div
                            v-for="(photos, index) in package_tour.package_photos"
                            :key="photos.id"
                            class="w-12 h-12 flex shrink-0 rounded-lg overflow-hidden relative"
                        >
                            <img
                                :src="photos.photo_url"
                                class="w-full h-full object-cover object-center"
                                alt="thumbnail"
                            />
                            <div
                                v-if="index == package_tour.package_photos.length - 1"
                                class="w-12 h-12 flex items-center justify-center bg-[#1c273080] absolute"
                            >
                                <span class="font-semibold text-white">101+</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <a href="#" class="flex items-center justify-between py-2 text-custom-blue">
                <span class="style-body-bold">Read 2.546 more review</span>
                <div>
                    <img src="/icons/medium/arrow-circle-right.svg" alt="icon" />
                </div>
            </a>
        </div>
        <div
            class="navigation-bar fixed bottom-0 z-50 max-w-[640px] w-full h-[85px] bg-white rounded-t-[25px] flex items-center justify-between px-6"
        >
            <div class="flex flex-col gap-1 justify-center">
                <p class="text-custom-gray-dark style-subheadline">Total Price</p>
                <p class="font-semibold text-xl leading-[26px] tracking-[0.6px] text-custom-blue">
                    {{ package_tour.formatted_price }}<span class="text-custom-gray-dark font-normal">/pack</span>
                </p>
            </div>
            <Link :href="route('front.book', package_tour.slug)">
                <Button
                    size="small"
                    state="primary"
                    text="Book Now"
                    class="text-[16px] font-normal leading-[24px] tracking-[0px]"
                />
            </Link>
        </div>
    </section>
</template>
