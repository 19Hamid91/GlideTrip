<script setup>
import { Head, Link } from '@inertiajs/vue3';
</script>
<template>
    <Head title="Success" />
    <section id="content" class="max-w-[640px] w-full mx-auto bg-custom-blue min-h-screen">
        <div class="w-full min-h-screen flex flex-col items-center justify-center py-[46px] px-[28px] gap-8">
            <div class="w-[calc(100%-26px)] rounded-[20px] overflow-hidden relative mx-1">
                <img src="/images/Success-Illustration.png" alt="background" class="w-full h-full object-contain" />
            </div>
            <div class="flex flex-col gap-2 items-center text-center w-[319px] mx-auto">
                <p class="font-semibold style-headline text-white">Transaction Success</p>
                <p class="text-white">Ready to go! don't forget to check<br />tour trip on Schedule Page</p>
            </div>
            <Link
                :href="route('dashboard.bookings')"
                class="p-[16px_24px] rounded-xl bg-white w-full text-center font-semibold text-custom-blue hover:bg-[#06C755] hover:text-white transition-all duration-300"
                >Check Schedule Page</Link
            >
        </div>
    </section>
</template>
