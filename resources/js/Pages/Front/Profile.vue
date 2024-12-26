<script setup>
import { ref } from 'vue';
import { Head, usePage, useForm, Link } from '@inertiajs/vue3';
import Navigation from '@/Components/Navigation.vue';
import Button from '@/Components/Button.vue';

const page = usePage();
const isEdit = ref(0);
const user = ref(page.props.user);
const fileInput = ref(null);

const form = useForm({
    _method: 'patch',
    name: user.value.name,
    email: user.value.email,
    phone_number: user.value.phone_number,
    avatar: null
});

const toggleEdit = () => {
    isEdit.value = !isEdit.value;
};

const triggerFileInput = () => {
    if (isEdit.value) {
        fileInput.value.click();
    }
};

const handleFileChange = (event) => {
    const file = event.target.files[0];
    if (file) {
        form.avatar = file;
        user.value.avatar_url = URL.createObjectURL(file);
    }
};

const handleNumberInput = (event) => {
    const value = event.target.value;
    event.target.value = value.replace(/[^0-9]/g, '');
};

const updateUser = () => {
    form.post(route('front.profile.update'), {
        onFinish: () => {
            toggleEdit();
        }
    });
};
</script>
<template>
    <Head title="Profile" />

    <section class="flex flex-col max-w-[640px] w-full mx-auto bg-custom-background min-h-screen gap-8 pb-[120px]">
        <Navigation text="Profile" />
        <form @submit.prevent="submit" class="flex flex-col gap-8 justify-center">
            <div class="flex flex-col gap-3 px-4">
                <div class="flex w-full justify-center">
                    <div
                        class="relative w-36 h-36 border-4 border-white rounded-full overflow-hidden flex shrink-0 shadow-[6px_8px_wopx_0_#00000008]"
                        @click="triggerFileInput"
                    >
                        <img :src="user.avatar_url" alt="avatar" class="object-cover w-full h-full" />
                        <div
                            v-show="isEdit"
                            class="absolute inset-0 bg-gray-500 bg-opacity-50 flex items-center justify-center text-white font-bold"
                        >
                            Edit
                        </div>
                        <input ref="fileInput" type="file" name="avatar" class="hidden" @change="handleFileChange" />
                    </div>
                </div>
                <div class="bg-white p-[16px_24px] rounded-[26px] flex flex-col gap-3">
                    <div class="flex justify-between items-center style-body">
                        <p>Name</p>
                        <p v-if="!isEdit" class="font-semibold">{{ form.name }}</p>
                        <input
                            v-else
                            type="text"
                            v-model="form.name"
                            class="border-custom-gray-100 foucs:border-custom-blue rounded-full"
                            autofocus
                        />
                    </div>
                    <div class="flex justify-between items-center style-body">
                        <p>Email</p>
                        <p v-if="!isEdit" class="font-semibold">{{ form.email }}</p>
                        <input
                            v-else
                            type="email"
                            v-model="form.email"
                            class="border-custom-gray-100 foucs:border-custom-blue rounded-full"
                        />
                    </div>
                    <div class="flex justify-between items-center style-body">
                        <p>Phone</p>
                        <p v-if="!isEdit" class="font-semibold">{{ form.phone_number }}</p>
                        <input
                            v-else
                            type="tel"
                            v-model="form.phone_number"
                            class="border-custom-gray-100 foucs:border-custom-blue rounded-full"
                            @input="handleNumberInput"
                        />
                    </div>
                </div>
            </div>
            <div class="px-4">
                <Button @click="toggleEdit" v-if="!isEdit" text="Edit" size="medium" class="w-full" />
                <Button @click="updateUser" v-else text="Save" size="medium" state="reverse" class="w-full" />
                <hr class="my-5" />
                <Link href="/logout" method="post" as="button" class="w-full">
                    <Button class="bg-pink-500 w-full hover:bg-pink-800" size="medium" text="Logout" />
                </Link>
            </div>
        </form>
    </section>
</template>
