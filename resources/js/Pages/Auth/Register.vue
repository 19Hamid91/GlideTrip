<script setup>
import { ref } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import InputField from '@/Components/InputField.vue';
import Button from '@/Components/Button.vue';
import InputError from '@/Components/InputError.vue';

const form = useForm({
    name: '',
    phone_number: '',
    avatar: '',
    email: '',
    password: '',
    password_confirmation: ''
});

const isConfirmPasswordVisible = ref(false);
const isPasswordVisible = ref(false);

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation')
    });
};

const handleFileChange = (event) => {
    form.avatar = event.target.files[0];
};

const togglePasswordVisibility = (type) => {
    if (type === 'confirm-password') {
        isConfirmPasswordVisible.value = !isConfirmPasswordVisible.value;
    } else {
        isPasswordVisible.value = !isPasswordVisible.value;
    }
};
</script>

<template>
    <Head title="Register" />

    <section id="content" class="max-w-[640px] w-full mx-auto bg-custom-background min-h-screen">
        <div class="w-full min-h-screen flex flex-col items-center justify-center py-[46px] px-4 gap-8">
            <div class="w-[calc(100%-26px)] rounded-[20px] overflow-hidden relative">
                <img class="w-full h-full object-contain" src="/images/signup.png" alt="Sign Up Icon" />
            </div>
            <form
                @submit.prevent="submit"
                enctype="multipart/form-data"
                class="flex flex-col w-full bg-white p-[24px_16px] gap-8 rounded-[22px] items-center"
            >
                <div class="flex flex-col gap-1 text-center">
                    <h1 class="style-headline text-custom-black">Sign Up</h1>
                    <p class="style-subheadline text-custom-gray-dark">Enter valid data to create your account</p>
                </div>
                <div class="flex flex-col gap-[15px] w-full max-w-[311px]">
                    <div class="flex flex-col gap-1 w-full">
                        <p class="font-semibold">Avatar</p>
                        <div
                            class="flex items-center gap-3 p-[16px_12px] border border-custom-gray-200 rounded-xl focus-within:border-custom-blue transition-all duration-300 overflow-hidden"
                        >
                            <div class="w-4 h-4 flex shrink-0">
                                <img src="/icons/small/gallery.svg" alt="icon" />
                            </div>
                            <label for="avatar" id="upload-file" class="flex items-center gap-3">
                                <div
                                    id="chosse-file-dummy-btn"
                                    class="border border-custom-gray-dark bg-custom-gray-100 py-1 px-2 rounded-lg text-nowrap text-sm leading-[22px] tracking-035 h-fit"
                                >
                                    Choose File
                                </div>
                                <div>
                                    <p id="placeholder" class="text-nowrap text-custom-gray-200 style-body text-left">
                                        {{ form.avatar ? form.avatar.name : 'No file chosen' }}
                                    </p>
                                    <div id="file-info" class="flex flex-row flex-nowrap gap-3 items-center">
                                        <span id="fileName" class="text-custom-gray-200 style-body text-nowrap"></span>
                                    </div>
                                </div>
                                <input
                                    type="file"
                                    name="avatar"
                                    id="avatar"
                                    class="hidden"
                                    @change="handleFileChange"
                                />
                            </label>
                        </div>
                        <InputError :message="form.errors.avatar" class="mt-2" />
                    </div>
                    <InputField
                        tag="input"
                        inputType="text"
                        labelText="Full Name"
                        placeholderText="Write your full name"
                        leadIcon="/icons/small/user.svg"
                        required
                        name="name"
                        v-model="form.name"
                        :errorText="form.errors.name"
                    />
                    <InputField
                        tag="input"
                        inputType="tel"
                        labelText="Phone Number"
                        placeholderText="Your valid phone number"
                        leadIcon="/icons/small/call.svg"
                        required
                        name="phone_number"
                        v-model="form.phone_number"
                        :errorText="form.errors.phone_number"
                    />
                    <InputField
                        tag="input"
                        inputType="email"
                        labelText="Email Address"
                        placeholderText="Your email address"
                        leadIcon="/icons/small/sms.svg"
                        required
                        name="email"
                        v-model="form.email"
                        :errorText="form.errors.email"
                    />
                    <div class="flex flex-col gap-1 w-full">
                        <p class="font-semibold">Password</p>
                        <div
                            class="flex items-center gap-3 p-[16px_12px] border border-custom-gray-200 rounded-xl focus-within:border-custom-blue transition-all duration-300"
                        >
                            <div class="w-4 h-4 flex shrink-0">
                                <img src="/icons/small/lock.svg" alt="icon" />
                            </div>
                            <input
                                :type="isPasswordVisible ? 'text' : 'password'"
                                name="password"
                                class="appearance-none outline-none w-full text-sm placeholder:text-custom-gray-200 border-custom-gray-200 tracking-[0.35px] border-none m-0 p-0"
                                v-model="form.password"
                                placeholder="Enter your valid password"
                            />
                            <button
                                type="button"
                                class="reveal-password w-4 h-4 flex shrink-0"
                                id="password"
                                @click="togglePasswordVisibility('password')"
                            >
                                <img
                                    v-if="!isPasswordVisible"
                                    src="/icons/small/password-eye.svg"
                                    class="see-password"
                                    alt="icon"
                                />
                                <img v-else src="/icons/small/password-eye-slash.svg" class="" alt="icon" />
                            </button>
                        </div>
                        <InputError :message="form.errors.password" class="mt-2" />
                    </div>
                    <div class="flex flex-col gap-1 w-full">
                        <p class="font-semibold">Confirm Password</p>
                        <div
                            class="flex items-center gap-3 p-[16px_12px] border border-custom-gray-200 rounded-xl focus-within:border-custom-blue transition-all duration-300"
                        >
                            <div class="w-4 h-4 flex shrink-0">
                                <img src="/icons/small/lock.svg" alt="icon" />
                            </div>
                            <input
                                :type="isConfirmPasswordVisible ? 'text' : 'password'"
                                name="password_confirmation"
                                class="appearance-none outline-none w-full text-sm placeholder:text-custom-gray-200 border-custom-gray-200 tracking-[0.35px] border-none m-0 p-0"
                                v-model="form.password_confirmation"
                                placeholder="Confirm your valid password"
                            />
                            <button
                                type="button"
                                class="reveal-password w-4 h-4 flex shrink-0"
                                id="confirm-password"
                                @click="togglePasswordVisibility('confirm-password')"
                            >
                                <img
                                    v-if="!isConfirmPasswordVisible"
                                    src="/icons/small/password-eye.svg"
                                    class="see-password"
                                    alt="icon"
                                />
                                <img v-else src="/icons/small/password-eye-slash.svg" class="" alt="icon" />
                            </button>
                        </div>
                        <InputError :message="form.errors.password_confirmation" class="mt-2" />
                    </div>
                </div>
                <Button size="medium" state="primary" text="Sign In" buttonType="submit" />
                <p class="text-center text-custom-gray-dark style-body">
                    Already have an account?<a href="/login" class="text-custom-blue style-body-bold"> Sign In</a>
                </p>
            </form>
        </div>
    </section>
</template>
