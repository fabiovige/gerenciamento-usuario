<script setup>
import { ref } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import ApplicationMark from '@/Components/ApplicationMark.vue';
import Banner from '@/Components/Banner.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import FlashMessage from '@/Components/FlashMessage.vue';
import { useI18n } from 'vue-i18n';

const { t } = useI18n();

defineProps({
    title: String,
});

const showingNavigationDropdown = ref(false);
const sidebarOpen = ref(true);

const logout = () => {
    router.post(route('logout'));
};

const toggleSidebar = () => {
    sidebarOpen.value = !sidebarOpen.value;
};
</script>

<template>
    <div>
        <Head :title="title" />
        <Banner />
        <FlashMessage />

        <div class="min-h-screen bg-gray-100 flex">
            <!-- Sidebar -->
            <div
                :class="[
                    'fixed left-0 top-0 h-full bg-gray-900 text-white transition-all duration-300 ease-in-out z-20 flex flex-col',
                    sidebarOpen ? 'w-64' : 'w-20'
                ]"
            >
                <!-- Logo -->
                <div class="flex items-center justify-between p-4 border-b border-gray-800">
                    <Link :href="route('dashboard')" class="flex items-center space-x-3">
                        <ApplicationMark class="block h-9 w-auto text-gray-200" />
                        <span v-show="sidebarOpen" class="text-xl font-semibold">{{ t('app.name') }}</span>
                    </Link>
                    <button @click="toggleSidebar" class="text-gray-400 hover:text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path v-if="sidebarOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
                            <path v-else stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>

                <!-- Navigation Links -->
                <nav class="mt-5 px-2">
                    <Link
                        :href="route('dashboard')"
                        :class="[
                            'flex items-center px-4 py-2 rounded-lg transition-colors',
                            route().current('dashboard')
                                ? 'bg-gray-800 text-white'
                                : 'text-gray-400 hover:text-white hover:bg-gray-800'
                        ]"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        <span v-show="sidebarOpen" class="ml-3">{{ t('menu.dashboard') }}</span>
                    </Link>

                    <Link
                        :href="route('users.index')"
                        :class="[
                            'flex items-center px-4 py-2 mt-2 rounded-lg transition-colors',
                            route().current('users.*')
                                ? 'bg-gray-800 text-white'
                                : 'text-gray-400 hover:text-white hover:bg-gray-800'
                        ]"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <span v-show="sidebarOpen" class="ml-3">{{ t('menu.users') }}</span>
                    </Link>
                </nav>

                <!-- Adiciona flex-grow para empurrar o footer para baixo -->
                <div class="flex-grow"></div>

                <!-- Sidebar Footer -->
                <div class="border-t border-gray-800 p-4">
                    <button
                        @click="logout"
                        class="flex items-center w-full px-4 py-2 text-sm text-gray-400 hover:text-white hover:bg-gray-800 rounded-lg transition-colors"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        <span v-show="sidebarOpen" class="ml-3">{{ t('auth.logout') }}</span>
                    </button>
                </div>
            </div>

            <!-- Main Content -->
            <div :class="['flex-1 flex flex-col min-h-screen transition-all duration-300 ease-in-out', sidebarOpen ? 'ml-64' : 'ml-20']">
                <!-- Header -->
                <header class="bg-white shadow">
                    <div class="w-full px-4 py-6">
                        <div class="flex items-center justify-between">
                            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                                <slot name="header" />
                            </h2>

                            <!-- User Profile Dropdown -->
                            <Dropdown
                                align="right"
                                width="48"
                                contentClasses="bg-white py-1 rounded-md shadow-xl ring-1 ring-black ring-opacity-5"
                            >
                                <template #trigger>
                                    <button class="flex items-center text-sm hover:opacity-80 transition-opacity duration-150 ease-in-out focus:outline-none">
                                        <div v-if="$page.props.jetstream.managesProfilePhotos" class="flex-shrink-0">
                                            <img
                                                class="h-10 w-10 rounded-full object-cover border-2 border-gray-200"
                                                :src="$page.props.auth.user.profile_photo_url"
                                                :alt="$page.props.auth.user.name"
                                            >
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-gray-700">{{ $page.props.auth.user.name }}</p>

                                        </div>
                                        <svg class="ml-2 h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </template>

                                <template #content>

                                    <div class="relative">
                                        <DropdownLink
                                            :href="route('profile.show')"
                                            class="w-full"
                                        >
                                            <div class="flex items-center px-3 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                                <span class="ml-2">{{ t('auth.profile') }}</span>
                                            </div>
                                        </DropdownLink>

                                        <div class="border-t border-gray-100"></div>

                                        <form @submit.prevent="logout" class="w-full">
                                            <DropdownLink as="button" class="w-full">
                                                <div class="flex items-center px-3 py-2 text-sm text-red-600 hover:bg-red-50">
                                                    <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                                    </svg>
                                                    <span class="ml-2">{{ t('auth.logout') }}</span>
                                                </div>
                                            </DropdownLink>
                                        </form>
                                    </div>
                                </template>
                            </Dropdown>
                        </div>
                    </div>
                </header>

                <!-- Sub-header com Breadcrumb e Botão Voltar -->
                <div class="bg-gray-50 border-b border-gray-200">
                    <div class="w-full px-4 py-3">
                        <div class="flex items-center justify-between">
                            <!-- Breadcrumb -->
                            <div class="text-sm text-gray-500">
                                <slot name="breadcrumb" />
                            </div>

                            <!-- Botão Voltar -->
                            <div>
                                <slot name="actions" />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Page Content -->
                <main class="flex-grow py-12">
                    <div class="w-full px-4">
                        <slot />
                    </div>
                </main>

                <!-- Footer -->
                <footer class="bg-white shadow">
                    <div class="w-full px-4 py-4">
                        <div class="flex justify-between items-center text-sm text-gray-500">
                            <div>{{ t('app.name') }} © {{ new Date().getFullYear() }}</div>
                            <div>{{ t('app.rights') }}</div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
    </div>
</template>
