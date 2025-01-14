<script setup>
import { Link } from '@inertiajs/vue3';
import Pagination from '@/Components/Pagination.vue';

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
    }
});

const emit = defineEmits(['actionClick']);

const handleActionClick = (action, item) => {
    emit('actionClick', { action, item });
};
</script>

<template>
    <div>
        <table class="min-w-full divide-y divide-gray-200">
            <thead>
                <tr>
                    <th
                        v-for="column in columns"
                        :key="column.key"
                        class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider"
                    >
                        {{ column.label }}
                    </th>
                    <th v-if="actions.length" class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                        Actions
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
