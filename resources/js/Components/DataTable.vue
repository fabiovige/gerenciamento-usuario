<script setup>
import { Link } from '@inertiajs/vue3';
import Pagination from '@/Components/Pagination.vue';
import { ref, watch } from 'vue';
import { router } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';

const { t } = useI18n();

const props = defineProps({
    columns: {
        type: Array,
        required: true
    },
    data: {
        type: Object,
        required: true
    },
    actions: {
        type: Array,
        default: () => []
    },
    filters: {
        type: Object,
        default: () => ({})
    }
});

const emit = defineEmits(['actionClick']);

const search = ref(props.filters.search || '');
let timeout;

watch(() => props.filters, (newFilters) => {
    search.value = newFilters.search || '';
}, { deep: true });

const handleSearch = () => {
    clearTimeout(timeout);
    timeout = setTimeout(() => {
        router.get(
            route(route().current()),
            { search: search.value },
            {
                preserveState: true,
                preserveScroll: true,
                replace: true
            }
        );
    }, 300);
};

const handleActionClick = (action, item) => {
    emit('actionClick', { action, item });
};
</script>

<template>
    <div>
        <!-- Header com busca e botão -->
        <div class="flex justify-between items-center mb-4">
            <div class="max-w-md flex-1 mr-4">
                <div class="relative rounded-md shadow-sm">
                    <input
                        id="search"
                        v-model="search"
                        type="text"
                        class="block w-full rounded-md border-gray-300 pr-10 focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                        :placeholder="t('common.search')"
                        @input="handleSearch"
                    >
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                        <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
            </div>
            <slot name="actions"></slot>
        </div>

        <table class="min-w-full divide-y divide-gray-200">
            <thead>
                <tr>
                    <th
                        v-for="column in columns"
                        :key="column.key"
                        class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider"
                    >
                        {{ t(`users.${column.key}`) }}
                    </th>
                    <th v-if="actions.length" class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                        {{ t('common.actions') }}
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <tr v-for="item in data.data" :key="item.id">
                    <td
                        v-for="column in columns"
                        :key="column.key"
                        class="px-6 py-4 whitespace-no-wrap"
                    >
                        {{ item[column.key] }}
                    </td>
                    <td v-if="actions.length" class="px-6 py-4 whitespace-no-wrap flex">
                        <template v-for="action in actions" :key="action.label">
                            <Link
                                v-if="action.type === 'link'"
                                :href="action.href(item)"
                                :class="[
                                    'mr-3',
                                    action.class || 'text-indigo-600 hover:text-indigo-900'
                                ]"
                            >
                                {{ action.label }}
                            </Link>
                            <button
                                v-else
                                @click="handleActionClick(action, item)"
                                :class="[
                                    'mr-3',
                                    action.class || 'text-red-600 hover:text-red-900'
                                ]"
                            >
                                {{ action.label }}
                            </button>
                        </template>
                    </td>
                </tr>
            </tbody>
        </table>

        <Pagination
            v-if="data.links"
            :links="data.links"
        />
    </div>
</template>
