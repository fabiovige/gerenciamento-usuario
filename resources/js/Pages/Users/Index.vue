<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link, router } from '@inertiajs/vue3';
import DataTable from '@/Components/DataTable.vue';

const props = defineProps({
    users: Object,
});

const columns = [
    { key: 'name', label: 'Name' },
    { key: 'email', label: 'Email' },
];

const actions = [
    {
        type: 'link',
        label: 'Edit',
        href: (user) => route('users.edit', user.id),
        class: 'text-indigo-600 hover:text-indigo-900'
    },
    {
        type: 'button',
        label: 'Delete',
        action: 'delete',
        class: 'text-red-600 hover:text-red-900'
    }
];

const handleAction = ({ action, item }) => {
    if (action.action === 'delete') {
        if (confirm('Are you sure you want to delete this user?')) {
            router.delete(route('users.destroy', item.id));
        }
    }
};
</script>

<template>
    <AppLayout title="Users">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Users
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex justify-between mb-6">
                        <h3 class="text-lg font-medium text-gray-900">User List</h3>
                        <Link
                            :href="route('users.create')"
                            class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700"
                        >
                            Add New User
                        </Link>
                    </div>

                    <DataTable
                        :columns="columns"
                        :data="users"
                        :actions="actions"
                        @action-click="handleAction"
                    />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
