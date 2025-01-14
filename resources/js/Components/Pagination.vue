<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    links: {
        type: Array,
        required: true,
    },
});

const cleanLabel = (label) => {
    return label.replace('&laquo;', '«')
               .replace('&raquo;', '»')
               .replace('Previous', 'Anterior')
               .replace('Next', 'Próximo');
};
</script>

<template>
    <div v-if="links.length > 3" class="flex flex-wrap justify-center mt-4">
        <template v-for="(link, key) in links" :key="key">
            <!-- Pula os links Previous e Next quando estiverem desabilitados -->
            <template v-if="link.url === null && !['Previous', 'Next', '&laquo; Previous', 'Next &raquo;'].includes(link.label)">
                <div class="px-4 py-2 mx-1 text-sm text-gray-700 bg-white border rounded">
                    {{ cleanLabel(link.label) }}
                </div>
            </template>

            <Link
                v-else-if="link.url"
                :href="link.url"
                class="px-4 py-2 mx-1 text-sm border rounded"
                :class="{
                    'bg-blue-50 border-blue-500 text-blue-600': link.active,
                    'text-gray-700 hover:bg-gray-50': !link.active
                }"
            >
                {{ cleanLabel(link.label) }}
            </Link>
        </template>
    </div>
</template>
