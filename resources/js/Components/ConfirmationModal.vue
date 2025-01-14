<script setup>
import { ref } from 'vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';

const props = defineProps({
    show: Boolean,
    title: String,
    message: String,
});

const emit = defineEmits(['close', 'confirm']);
</script>

<template>
    <Modal :show="show" @close="$emit('close')">
        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-medium text-gray-900">
                    {{ title }}
                </h2>

                <button
                    type="button"
                    class="rounded-md text-gray-400 hover:text-gray-500 focus:outline-none"
                    @click="$emit('close')"
                >
                    <span class="sr-only">Close</span>
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="mt-4">
                <p class="text-sm text-gray-500">
                    {{ message }}
                </p>
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                <SecondaryButton @click="$emit('close')">
                    Cancel
                </SecondaryButton>

                <DangerButton @click="$emit('confirm')">
                    Delete
                </DangerButton>
            </div>
        </div>
    </Modal>
</template>
