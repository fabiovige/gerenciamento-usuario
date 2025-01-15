<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm, Link } from '@inertiajs/vue3';
import FormSection from '@/Components/FormSection.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import PasswordInput from '@/Components/PasswordInput.vue';
import { useI18n } from 'vue-i18n';

const { t } = useI18n();

const props = defineProps({
    filters: Object,
});

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    _query: {
        search: props.filters?.search
    }
});

const createUser = () => {
    form.post(route('users.store'), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
        },
    });
};
</script>

<template>
    <AppLayout :title="t('users.create')">
        <!-- Header Principal -->
        <template #header>
            {{ t('users.create') }}
        </template>

        <!-- Breadcrumb -->
        <template #breadcrumb>
            {{ t('menu.dashboard') }} / {{ t('users.title') }} / {{ t('users.create') }}
        </template>

        <!-- Botão Voltar -->
        <template #actions>
            <Link
                :href="route('users.index', { search: $page.props.filters?.search })"
                class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
            >
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                {{ t('common.back') }}
            </Link>
        </template>

        <div class="py-6">
            <div class="w-full">
                <FormSection @submitted="createUser">
                    <template #title>
                        {{ t('users.user_information') }}
                    </template>

                    <template #description>
                        {{ t('users.create_description') }}
                    </template>

                    <template #form>
                        <div class="col-span-6 sm:col-span-4">
                            <InputLabel for="name" value="Name" />
                            <TextInput
                                id="name"
                                v-model="form.name"
                                type="text"
                                class="mt-1 block w-full"
                                required
                                autofocus
                            />
                            <InputError :message="form.errors.name" class="mt-2" />
                        </div>

                        <div class="col-span-6 sm:col-span-4">
                            <InputLabel for="email" value="Email" />
                            <TextInput
                                id="email"
                                v-model="form.email"
                                type="email"
                                class="mt-1 block w-full"
                                required
                            />
                            <InputError :message="form.errors.email" class="mt-2" />
                        </div>

                        <div class="col-span-6 sm:col-span-4">
                            <InputLabel for="password" value="Password" />
                            <PasswordInput
                                id="password"
                                v-model="form.password"
                                class="mt-1 block w-full"
                                required
                                autocomplete="new-password"
                            />
                            <InputError :message="form.errors.password" class="mt-2" />
                        </div>

                        <div class="col-span-6 sm:col-span-4">
                            <InputLabel for="password_confirmation" value="Confirm Password" />
                            <PasswordInput
                                id="password_confirmation"
                                v-model="form.password_confirmation"
                                class="mt-1 block w-full"
                                required
                                autocomplete="new-password"
                            />
                        </div>
                    </template>

                    <template #actions>
                        <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            {{ t('common.create') }}
                        </PrimaryButton>
                    </template>
                </FormSection>
            </div>
        </div>
    </AppLayout>
</template>
