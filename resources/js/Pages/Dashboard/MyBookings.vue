<script setup>
import { onMounted } from 'vue';
import { Head, usePage, Link } from '@inertiajs/vue3';
import Navigation from '@/Components/Navigation.vue';
import Badge from '@/Components/Badge.vue';
import NavBottom from '@/Components/NavBottom.vue';

const page = usePage();
const packageBookings = page.props.packageBookings || [];

onMounted(() => {
    splitTextIntoTwoLines();
});

function splitTextIntoTwoLines() {
    var paragraphs = document.querySelectorAll('.two-lines');

    paragraphs.forEach(function (paragraph) {
        var text = paragraph.textContent.trim();
        var words = text.split(' ');
        var halfwayIndex = Math.ceil(words.length / 2);
        var firstHalf = words.slice(0, halfwayIndex).join(' ');
        var secondHalf = words.slice(halfwayIndex).join(' ');

        paragraph.innerHTML = firstHalf + '<br>' + secondHalf;
    });
}
</script>
<template>
    <Head title="My Bookings" />
    <section
        id="content"
        class="max-w-[640px] w-full mx-auto bg-custom-background min-h-screen flex flex-col gap-8 pb-[120px]"
    >
        <Navigation text="Schedule" />
        <div class="flex flex-col gap-3 px-4">
            <h1 v-if="packageBookings.length == 0" class="style-title text-custom-gray-dark text-center">
                There is no booked trip
            </h1>
            <Link
                v-for="packageBooking in packageBookings"
                :key="packageBooking.id"
                :href="route('dashboard.booking.detail', packageBooking.id)"
                class="card"
            >
                <div class="bg-white p-4 rounded-[26px] flex flex-col gap-3">
                    <div class="flex items-center gap-4">
                        <div class="flex flex-col text-center">
                            <h2 class="style-headline">{{ packageBooking.day }}</h2>
                            <p class="style-body">{{ packageBooking.month }}</p>
                            <p class="style-body">{{ packageBooking.year }}</p>
                        </div>
                        <div class="w-[92px] h-[92px] flex shrink-0 rounded-xl overflow-hidden">
                            <img :src="packageBooking.tour.thumbnail_url" alt="thumbnail" />
                        </div>
                        <div class="flex flex-col gap-1">
                            <p class="font-semibold two-lines">{{ packageBooking.tour.name }}</p>
                            <div class="flex items-center gap-1">
                                <span class="style-body text-custom-gray-dark"
                                    >{{ packageBooking.tour.days }} days | {{ packageBooking.quantity }} packs
                                </span>
                            </div>
                            <Badge v-show="packageBookings.is_paid" text="Success Paid" />
                        </div>
                    </div>
                </div>
            </Link>
        </div>
        <NavBottom active="schedule" />
    </section>
</template>
