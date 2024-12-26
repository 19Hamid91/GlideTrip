<template>
    <div
        class="navigation-bar fixed bottom-0 z-50 max-w-[640px] w-full h-[85px] bg-white rounded-t-[25px] flex items-center justify-evenly py-[45px]"
    >
        <a href="/" :class="['menu', active !== 'home' ? 'opacity-25' : '']">
            <div class="flex flex-col justify-center w-fit gap-1">
                <div class="w-4 h-4 flex shrink-0 overflow-hidden mx-auto text-custom-blue">
                    <img src="/icons/small/home.svg" alt="icon" />
                </div>
                <p class="style-caption-bold">Home</p>
            </div>
        </a>
        <a :href="route('front.search')" :class="['menu', active !== 'search' ? 'opacity-25' : '']">
            <div class="flex flex-col justify-center w-fit gap-1">
                <div class="w-4 h-4 flex shrink-0 overflow-hidden mx-auto text-custom-blue">
                    <img src="/icons/small/search.svg" alt="icon" />
                </div>
                <p class="style-caption-bold">Search</p>
            </div>
        </a>
        <a :href="route('dashboard.bookings')" :class="['menu', active !== 'schedule' ? 'opacity-25' : '']">
            <div class="flex flex-col justify-center w-fit gap-1">
                <div class="w-4 h-4 flex shrink-0 overflow-hidden mx-auto text-custom-blue">
                    <img src="/icons/small/calendar.svg" alt="icon" />
                </div>
                <p class="style-caption-bold">Schedule</p>
            </div>
        </a>
        <a :href="route('front.profile.edit')" :class="['menu', active !== 'profile' ? 'opacity-25' : '']">
            <div class="flex flex-col justify-center w-fit gap-1">
                <div class="w-4 h-4 flex shrink-0 overflow-hidden mx-auto text-custom-blue">
                    <img src="/icons/small/user.svg" alt="icon" />
                </div>
                <p class="style-caption-bold">Profile</p>
            </div>
        </a>
    </div>
</template>

<script>
export default {
    props: {
        active: {
            type: String,
            default: 'home'
        }
    }
};
</script>
