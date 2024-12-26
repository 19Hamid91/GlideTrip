<script setup>
import { ref } from 'vue';
import { usePage, Head, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const page = usePage();
const form = useForm({});
const roles = page.props.roles || [];
const isSuperAdmin = roles.includes('super_admin');
const banks = ref(page.props.banks || { data: [], links: [] });

const deleteBank = async (bankId) => {
    if (confirm('Are you sure you want to delete this bank?')) {
        form.delete(route('admin.package_banks.destroy', { package_bank: bankId }), {
            onSuccess: () => {
                banks.value.data = banks.value.data.filter((bank) => bank.id !== bankId);
            }
        });
    }
};
</script>

<template>
    <Head title="Bank" />

    <AuthenticatedLayout :is-super-admin="isSuperAdmin">
        <template #header>
            <div class="flex flex-row justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Manage Banks</h2>
                <a
                    :href="route('admin.package_banks.create')"
                    class="font-bold py-4 px-6 bg-indigo-700 text-white rounded-full"
                >
                    Add New
                </a>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-10 flex flex-col gap-y-5">
                    <div v-if="banks.data.length === 0" class="text-center text-gray-500">No banks available.</div>

                    <div v-else>
                        <div
                            v-for="bank in banks.data"
                            :key="bank.id"
                            class="item-card flex flex-row justify-between items-center mb-4"
                        >
                            <div class="flex flex-row items-center gap-x-3">
                                <img
                                    :src="bank.logo_url"
                                    :alt="bank.bank_name + ' image'"
                                    class="rounded-2xl object-cover w-[90px] h-[90px]"
                                />
                                <div class="flex flex-col">
                                    <h3 class="text-indigo-950 text-xl font-bold">{{ bank.bank_name }}</h3>
                                </div>
                            </div>
                            <div class="hidden md:flex flex-col">
                                <p class="text-slate-500 text-sm">Date</p>
                                <h3 class="text-indigo-950 text-xl font-bold">
                                    {{ bank.formatted_created_at }}
                                </h3>
                            </div>
                            <div class="hidden md:flex flex-row items-center gap-x-3">
                                <a
                                    :href="route('admin.package_banks.edit', { package_bank: bank.id })"
                                    class="font-bold py-4 px-6 bg-indigo-700 text-white rounded-full"
                                >
                                    Edit
                                </a>
                                <form @submit.prevent="deleteBank(bank.id)">
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
