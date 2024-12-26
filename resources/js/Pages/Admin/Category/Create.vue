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
    name: '',
    icon: null
});

const submitForm = () => {
    form.post(route('admin.categories.store'), {
        onFinish: () => form.reset()
    });
};
</script>

<template>
    <Head title="New Category" />

    <AuthenticatedLayout :is-super-admin="isSuperAdmin">
        <template #header>
            <div class="flex flex-row justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">New Categories</h2>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden p-10 shadow-sm sm:rounded-lg">
                    <form @submit.prevent="submitForm" enctype="multipart/form-data">
                        <div>
                            <InputLabel for="name" value="Name" />
                            <TextInput
                                id="name"
                                class="block mt-1 w-full"
                                type="text"
                                v-model="form.name"
                                required
                                autofocus
                            />
                            <InputError :message="form.errors.name" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <InputLabel for="icon" value="Icon" />
                            <input
                                id="icon"
                                class="block mt-1 w-full"
                                type="file"
                                @change="(e) => (form.icon = e.target.files[0])"
                                required
                            />
                            <InputError :message="form.errors.icon" class="mt-2" />
                        </div>

                        <!-- Submit Button -->
                        <div class="flex items-center justify-end mt-4">
                            <button type="submit" class="font-bold py-4 px-6 bg-indigo-700 text-white rounded-full">
                                Add New Category
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
