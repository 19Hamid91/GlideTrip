<script setup>
import { ref } from 'vue';
import { usePage, Head, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';

const page = usePage();
const roles = page.props.roles || [];
const isSuperAdmin = roles.includes('super_admin');

// Form handling with Inertia
const form = useForm({
    bank_name: '',
    bank_account_name: '',
    bank_account_number: '',
    logo: null
});

const submitForm = () => {
    form.post(route('admin.package_banks.store'), {
        onFinish: () => form.reset()
    });
};
</script>

<template>
    <Head title="New Bank" />

    <AuthenticatedLayout :is-super-admin="isSuperAdmin">
        <template #header>
            <div class="flex flex-row justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">New Banks</h2>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden p-10 shadow-sm sm:rounded-lg">
                    <form @submit.prevent="submitForm" enctype="multipart/form-data">
                        <div class="mb-4">
                            <InputLabel for="bank_name" value="Bank Name" />
                            <TextInput
                                id="bank_name"
                                class="block mt-1 w-full"
                                type="text"
                                v-model="form.bank_name"
                                required
                                autofocus
                            />
                            <InputError :message="form.errors.bank_name" class="mt-2" />
                        </div>
                        <div class="mb-4">
                            <InputLabel for="bank_account_name" value="Bank Account Name" />
                            <TextInput
                                id="bank_account_name"
                                class="block mt-1 w-full"
                                type="text"
                                v-model="form.bank_account_name"
                                required
                            />
                            <InputError :message="form.errors.bank_account_name" class="mt-2" />
                        </div>
                        <div class="mb-4">
                            <InputLabel for="bank_account_number" value="Bank Account Number" />
                            <TextInput
                                id="bank_account_number"
                                class="block mt-1 w-full"
                                type="number"
                                v-model="form.bank_account_number"
                                @input="(e) => (form.bank_account_number = e.target.value.toString())"
                                required
                            />
                            <InputError :message="form.errors.bank_account_number" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <InputLabel for="logo" value="logo" />
                            <input
                                id="logo"
                                class="block mt-1 w-full"
                                type="file"
                                @change="(e) => (form.logo = e.target.files[0])"
                                required
                            />
                            <InputError :message="form.errors.logo" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <button type="submit" class="font-bold py-4 px-6 bg-indigo-700 text-white rounded-full">
                                Add New Bank
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
