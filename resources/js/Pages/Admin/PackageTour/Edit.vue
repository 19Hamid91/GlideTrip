<script setup>
import { ref } from 'vue';
import { usePage, Head, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import SelectInput from '@/Components/SelectInput.vue';
import TextAreaInput from '@/Components/TextAreaInput.vue';

const page = usePage();
const roles = page.props.roles || [];
const isSuperAdmin = roles.includes('super_admin');
const package_tour = ref(page.props.package_tour || { data: [], links: [] });
const categories = ref(page.props.categories || { data: [], links: [] });
const latestPhotos = page.props.latestPhotos || [];

// Form handling with Inertia
const form = useForm({
    _method: 'patch',
    name: package_tour.value.name,
    thumbnail: null,
    category_id: package_tour.value.category_id,
    about: package_tour.value.about,
    location: package_tour.value.location,
    price: package_tour.value.price,
    days: package_tour.value.days,
    package_photos: []
});

const submitForm = () => {
    form.post(route('admin.package_tours.update', { package_tour: package_tour.value.id }), {
        onFinish: () => form.reset()
    });
};
</script>

<template>
    <Head title="Edit Package Tour" />

    <AuthenticatedLayout :is-super-admin="isSuperAdmin">
        <template #header>
            <div class="flex flex-row justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Package Tour</h2>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden p-10 shadow-sm sm:rounded-lg">
                    <form @submit.prevent="submitForm" enctype="multipart/form-data">
                        <div class="mb-4">
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
                        <div class="mb-4">
                            <InputLabel for="thumbnail" value="Thumbnail" />
                            <img
                                :src="package_tour.thumbnail_url"
                                :alt="package_tour.name + ' thumbnail'"
                                class="rounded-2xl object-cover w-[90px] h-[90px]"
                            />
                            <input
                                id="thumbnail"
                                class="block mt-1 w-full"
                                type="file"
                                @change="(e) => (form.thumbnail = e.target.files[0])"
                            />
                            <InputError :message="form.errors.thumbnail" class="mt-2" />
                        </div>
                        <div class="mb-4">
                            <InputLabel for="category_id" value="Category" />
                            <SelectInput id="category_id" class="blockmt-1 w-full" v-model="form.category_id">
                                <option v-for="category in categories" :key="category.value" :value="category.id">
                                    {{ category.name }}
                                </option>
                            </SelectInput>
                            <InputError :message="form.errors.category_id" class="mt-2" />
                        </div>
                        <div class="mb-4">
                            <InputLabel for="about" value="About" />
                            <TextAreaInput
                                id="about"
                                class="block mt-1 w-full"
                                type="text"
                                v-model="form.about"
                                required
                            />
                            <InputError :message="form.errors.about" class="mt-2" />
                        </div>
                        <div class="mb-4">
                            <InputLabel for="location" value="Location" />
                            <TextInput
                                id="location"
                                class="block mt-1 w-full"
                                type="text"
                                v-model="form.location"
                                required
                            />
                            <InputError :message="form.errors.location" class="mt-2" />
                        </div>
                        <div class="mb-4">
                            <InputLabel for="price" value="Price" />
                            <TextInput
                                id="price"
                                class="block mt-1 w-full"
                                type="number"
                                v-model="form.price"
                                @input="(e) => (form.price = e.target.value.toString())"
                                required
                            />
                            <InputError :message="form.errors.price" class="mt-2" />
                        </div>
                        <div class="mb-4">
                            <InputLabel for="days" value="Days" />
                            <TextInput
                                id="days"
                                class="block mt-1 w-full"
                                type="number"
                                v-model="form.days"
                                @input="(e) => (form.days = e.target.value.toString())"
                                required
                            />
                            <InputError :message="form.errors.days" class="mt-2" />
                        </div>

                        <hr class="mb-4" />

                        <div v-for="i in 3" :key="i" class="mb-4">
                            <InputLabel for="package_photos" value="Photos" />
                            <img
                                v-if="latestPhotos[i - 1]"
                                :src="latestPhotos[i - 1].photo_url"
                                :alt="'image ' + i"
                                class="rounded-2xl object-cover w-[90px] h-[90px]"
                            />
                            <input
                                id="package_photos"
                                class="block mt-1 w-full"
                                type="file"
                                @change="(e) => (form.package_photos[i - 1] = e.target.files[0])"
                            />
                            <InputError :message="form.errors.package_photos" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <button type="submit" class="font-bold py-4 px-6 bg-indigo-700 text-white rounded-full">
                                Add New Tour
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
