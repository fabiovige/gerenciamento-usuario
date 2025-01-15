<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link, router } from '@inertiajs/vue3';
import DataTable from '@/Components/DataTable.vue';
import ConfirmationModal from '@/Components/ConfirmationModal.vue';
import { ref } from 'vue';
import { useI18n } from 'vue-i18n';

const { t } = useI18n();

const props = defineProps({
    users: Object,
    filters: Object,
});

const showDeleteModal = ref(false);
const userToDelete = ref(null);

const columns = [
    {
        key: 'name',
        label: t('users.name'),
        searchable: true
    },
    {
        key: 'email',
        label: t('users.email'),
        searchable: true
    },
];

const actions = [
    {
        type: 'link',
        label: t('users.edit_action'),
        href: (user) => route('users.edit', user.id),
        class: 'text-indigo-600 hover:text-indigo-900'
    },
    {
        type: 'button',
        label: t('users.delete_action'),
        action: 'delete',
        class: 'text-red-600 hover:text-red-900'
    }
];

const handleAction = ({ action, item }) => {
    if (action.action === 'delete') {
        userToDelete.value = item;
        showDeleteModal.value = true;
    }
};

const confirmDelete = () => {
    router.delete(route('users.destroy', userToDelete.value.id), {
        preserveScroll: true,
        onSuccess: () => {
            showDeleteModal.value = false;
            userToDelete.value = null;
        },
    });
};

const closeModal = () => {
    showDeleteModal.value = false;
    userToDelete.value = null;
};
</script>

<template>
    <AppLayout :title="t('users.title')">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ t('users.title') }}
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <DataTable
                        :columns="columns"
                        :data="users"
                        :actions="actions"
                        :filters="filters"
                        @action-click="handleAction"
                    >
                        <template #actions>
                            <Link
                                :href="route('users.create')"
                                class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700"
                            >
                                {{ t('users.add_new') }}
                            </Link>
                        </template>
                    </DataTable>

                    <ConfirmationModal
                        :show="showDeleteModal"
                        :title="t('users.delete')"
                        :message="t('users.confirm_delete', { name: userToDelete?.name })"
                        @close="closeModal"
                        @confirm="confirmDelete"
                    />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
