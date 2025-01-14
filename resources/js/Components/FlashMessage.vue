<script setup>
import { computed, onMounted, ref } from 'vue';
import { usePage } from '@inertiajs/vue3';

const page = usePage();
const isVisible = ref(true);

const flash = computed(() => page.props.flash);

const getTypeClasses = (type) => {
    switch (type) {
        case 'success':
            return 'bg-green-100 border-green-400 text-green-700';
        case 'error':
            return 'bg-red-100 border-red-400 text-red-700';
        default:
            return 'bg-blue-100 border-blue-400 text-blue-700';
    }
};

onMounted(() => {
    if (flash.value.message) {
        setTimeout(() => {
            isVisible.value = false;
        }, 3000); // 3 segundos
    }
});
</script>

<template>
    <div v-if="flash.message && isVisible" class="fixed top-4 right-4 z-50 animate-fade-in-down">
        <div
            :class="[
                'px-4 py-3 rounded relative border flex items-center justify-between min-w-[300px]',
                getTypeClasses(flash.type)
            ]"
            role="alert"
        >
            <span class="block pr-8">{{ flash.message }}</span>
            <button
                @click="isVisible = false"
                class="ml-4"
                type="button"
            >
                <svg
                    class="fill-current h-4 w-4"
                    role="button"
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 20 20"
                >
                    <title>Close</title>
                    <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/>
                </svg>
            </button>
        </div>
    </div>
</template>

<style scoped>
.animate-fade-in-down {
    animation: fadeInDown 0.5s ease-out;
    animation-fill-mode: forwards;
}

@keyframes fadeInDown {
    0% {
        opacity: 0;
        transform: translateY(-20px);
    }
    100% {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-out {
    animation: fadeOut 0.5s ease-out;
    animation-fill-mode: forwards;
}

@keyframes fadeOut {
    0% {
        opacity: 1;
        transform: translateY(0);
    }
    100% {
        opacity: 0;
        transform: translateY(-20px);
    }
}
</style>
