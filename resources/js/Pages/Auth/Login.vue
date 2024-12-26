<script setup>
import InputField from '@/Components/InputField.vue';
import Button from '@/Components/Button.vue';
import { Head, useForm } from '@inertiajs/vue3';

defineProps({
    status: {
        type: String
    }
});

const form = useForm({
    email: '',
    password: '',
    remember: false
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password')
    });
};
</script>

<template>
    <Head title="Log in" />

    <section id="content" class="max-w-[640px] w-full mx-auto bg-custom-background min-h-screen">
        <div class="w-full min-h-screen flex flex-col items-center justify-center py-[46px] px-4 gap-8">
            <div class="w-[calc(100%-26px)] rounded-[20px] overflow-hidden relative">
                <img class="w-full h-full object-contain" src="/./images/signin.png" alt="Sign In Image" />
            </div>

            <form
                @submit.prevent="submit"
                class="flex flex-col w-full bg-white p-[24px_16px] gap-8 rounded-[22px] items-center"
            >
                <div class="flex flex-col gap-1 text-center">
                    <h1 class="style-headline text-custom-black">Sign In</h1>
                    <p class="style-subheadline text-custom-gray-dark">Welcome Back! Enter your valid data</p>
                </div>
                <div class="flex flex-col gap-[15px] w-full max-w-[311px]">
                    <InputField
                        tag="input"
                        inputType="email"
                        labelText="Email"
                        placeholderText="Your email address"
                        leadIcon="/icons/small/sms.svg"
                        required
                        autofocus
                        name="email"
                        v-model="form.email"
                        :errorText="form.errors.email"
                    />
                    <InputField
                        tag="input"
                        inputType="password"
                        labelText="Password"
                        placeholderText="Enter your valid password"
                        leadIcon="/icons/small/lock.svg"
                        required
                        v-model="form.password"
                        name="password"
                        :errorText="form.errors.password"
                    />
                </div>
                <Button size="medium" state="primary" text="Sign In" buttonType="submit" />
                <p class="text-center text-custom-gray-dark style-body">
                    Don't have account?<a href="/register" class="text-custom-blue style-body-bold"> Sign Up</a>
                </p>
            </form>
        </div>
    </section>
</template>
