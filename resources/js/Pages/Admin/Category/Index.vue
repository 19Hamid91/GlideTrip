<script setup>
import { ref } from 'vue';
import { usePage, Head, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const page = usePage();
const form = useForm({});
const roles = page.props.roles || [];
const isSuperAdmin = roles.includes('super_admin');
const categories = ref(page.props.categories || { data: [], links: [] });

const deleteCategory = async (categoryId) => {
    if (confirm('Are you sure you want to delete this category?')) {
        form.delete(route('admin.categories.destroy', { category: categoryId }), {
            onSuccess: () => {
                categories.value.data = categories.value.data.filter((category) => category.id !== categoryId);
            }
        });
    }
};
</script>

<template>
    <Head title="Category" />

    <AuthenticatedLayout :is-super-admin="isSuperAdmin">
        <template #header>
            <div class="flex flex-row justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Manage Categories</h2>
                <a
                    :href="route('admin.categories.create')"
                    class="font-bold py-4 px-6 bg-indigo-700 text-white rounded-full"
                >
                    Add New
                </a>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-10 flex flex-col gap-y-5">
                    <div v-if="categories.data.length === 0" class="text-center text-gray-500">
                        No categories available.
                    </div>

                    <div v-else>
                        <div
                            v-for="category in categories.data"
                            :key="category.id"
                            class="item-card flex flex-row justify-between items-center mb-4"
                        >
                            <div class="flex flex-row items-center gap-x-3">
                                <img
                                    :src="category.icon_url"
                                    :alt="category.name + ' image'"
                                    class="rounded-2xl object-cover w-[90px] h-[90px]"
                                />
                                <div class="flex flex-col">
                                    <h3 class="text-indigo-950 text-xl font-bold">{{ category.name }}</h3>
                                </div>
                            </div>
                            <div class="hidden md:flex flex-col">
                                <p class="text-slate-500 text-sm">Date</p>
                                <h3 class="text-indigo-950 text-xl font-bold">
                                    {{ category.formatted_created_at }}
                                </h3>
                            </div>
                            <div class="hidden md:flex flex-row items-center gap-x-3">
                                <a
                                    :href="route('admin.categories.edit', { category: category.id })"
                                    class="font-bold py-4 px-6 bg-indigo-700 text-white rounded-full"
                                >
                                    Edit
                                </a>
                                <form @submit.prevent="deleteCategory(category.id)">
                                    <button
                                        type="submit"
                                        class="font-bold py-4 px-6 bg-red-700 text-white rounded-full"
                                    >
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
.item-card {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 1rem;
}
</style>
