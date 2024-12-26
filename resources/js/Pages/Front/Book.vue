<script setup>
import { computed, ref, onMounted } from 'vue';
import { Head, usePage, useForm, Link } from '@inertiajs/vue3';
import Navigation from '@/Components/Navigation.vue';
import Button from '@/Components/Button.vue';

const page = usePage();

const formatCurrency = (value) => {
    value = parseFloat(value);
    return `Rp ${value.toLocaleString('id-ID')}`;
};

const user = page.props.auth.user;
const package_tour = page.props.package_tour || [];

const quantity = ref(1);
const price = ref(package_tour.price);
const insurance = computed(() => 300000 * quantity.value);
const tax = computed(() => 0.11 * (price.value * quantity.value));
const subtotal = computed(() => price.value * quantity.value);
const grandtotal = computed(() => subtotal.value + insurance.value + tax.value);

const form = useForm({
    start_date: '',
    quantity: quantity.value
});

const addQuantity = () => {
    quantity.value += 1;
    form.quantity += 1;
};
const removeQuantity = () => {
    if (quantity.value > 1) {
        quantity.value -= 1;
        form.quantity -= 1;
    }
};

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

const handleBooking = () => {
    form.post(route('front.book.store', package_tour.slug), {
        onFinish: () => form.reset('start_date')
    });
};
</script>
<template>
    <Head title="Booking" />

    <section class="flex flex-col max-w-[640px] w-full mx-auto bg-custom-background min-h-screen gap-8 pb-[120px]">
        <Navigation text="Booking" />
        <form @submit.prevent="submit" class="flex flex-col gap-8">
            <div class="flex flex-col gap-3 px-4">
                <p class="font-semibold">Start Date</p>
                <div
                    class="flex items-center gap-[10px] bg-white p-[16px_24px] rounded-[37px] transition-all duration-300"
                >
                    <input
                        type="date"
                        name="start_date"
                        required
                        v-model="form.start_date"
                        id=""
                        class="appearance-none outline-none w-full relative text-sm tracking-035 leading-[22px] [&::-webkit-calendar-picker-indicator]:absolute [&::-webkit-calendar-picker-indicator]:w-full [&::-webkit-calendar-picker-indicator]:h-full [&::-webkit-calendar-picker-indicator]:opacity-0 custom-appearance-none"
                    />
                    <div class="w-6 h-6 flex shrink-0">
                        <img src="/icons/small/calendar.svg" class="w-full h-full" alt="icon" />
                    </div>
                </div>
            </div>
            <div class="flex flex-col gap-3 px-4">
                <p class="font-semibold">Trip Destination</p>
                <div class="bg-white p-4 rounded-[26px] flex items-center gap-3">
                    <div class="w-[72px] h-[72px] flex shrink-0 rounded-xl overflow-hidden">
                        <img :src="package_tour.thumbnail_url" alt="thumbnail" />
                    </div>
                    <div class="flex flex-col gap-1">
                        <p class="font-semibold two-lines">{{ package_tour.name }}</p>
                        <div class="flex items-center gap-1">
                            <div class="w-4 h-4">
                                <img src="/icons/small/location-map.svg" alt="icon" class="w-4 h-4" />
                            </div>
                            <span class="style-body text-custom-gray-dark">{{ package_tour.location }}</span>
                        </div>
                    </div>
                    <div class="flex flex-1 items-center justify-end gap-2">
                        <button type="button" @click="removeQuantity">
                            <img src="/icons/medium/minus-square.svg" alt="icon" />
                        </button>
                        <p class="font-semibold text-sm">{{ quantity }}</p>
                        <button type="button" @click="addQuantity">
                            <img src="/icons/medium/add-square.svg" alt="icon" />
                        </button>
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
                        <p class="font-semibold text-custom-blue">{{ formatCurrency(subtotal) }}</p>
                    </div>
                    <div class="flex justify-between items-center style-body">
                        <p>
                            Insurance <span class="text-custom-gray-dark">x{{ quantity }}</span>
                        </p>
                        <p class="font-semibold text-custom-blue">{{ formatCurrency(insurance) }}</p>
                    </div>
                    <div class="flex justify-between items-center style-body">
                        <p>Tax 11%</p>
                        <p class="font-semibold text-custom-blue">{{ formatCurrency(tax) }}</p>
                    </div>
                </div>
            </div>
            <div
                class="navigation-bar fixed bottom-0 z-50 max-w-[640px] w-full h-[85px] bg-black rounded-t-[25px] flex items-center justify-between px-6"
            >
                <div class="flex flex-col gap-1 justify-center">
                    <p class="text-white style-subheadline">Grand Total</p>
                    <p class="font-semibold text-xl leading-[26px] tracking-[0.6px] text-custom-yellow">
                        {{ formatCurrency(grandtotal) }}
                    </p>
                </div>
                <Button
                    size="small"
                    state="primary"
                    text="Booking"
                    class="text-[16px] font-normal leading-[24px] tracking-[0px]"
                    @click="handleBooking"
                />
            </div>
        </form>
    </section>
</template>
