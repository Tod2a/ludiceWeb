<script setup>
import { ref } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import Footer from '@/Components/Footer.vue';
import { Link } from '@inertiajs/vue3';
import ToastList from '@/Components/ToastList.vue';

const showingNavigationDropdown = ref(false);
</script>

<template>
    <div class="bg-white-100 min-h-screen flex flex-col">

        <ToastList />

        <!-- Header -->
        <nav class="bg-primary shadow-md border-b border-gray-100">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 justify-between">
                    <div class="flex items-center">
                        <!-- Logo -->
                        <Link :href="route('connected.homepage')">
                        <ApplicationLogo class="h-16 w-16 scale-75" />
                        </Link>
                    </div>

                    <!-- Navigation Links -->
                    <div class="hidden sm:flex sm:items-center sm:space-x-4">
                        <NavLink :href="route('connected.homepage')" :active="route().current('connected.homepage')">
                            Accueil
                        </NavLink>
                        <NavLink :href="route('library')" :active="route().current('library')">
                            Votre Ludothèque
                        </NavLink>
                        <div class="relative ms-3">
                            <!-- Settings Dropdown -->
                            <Dropdown align="right" width="48">
                                <template #trigger>
                                    <button type="button"
                                        class="inline-flex items-center rounded-md border border-transparent bg-green-800 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-green-700 focus:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-700 focus:ring-offset-2 active:bg-green-900">
                                        {{ $page.props.auth.user.name }}
                                        <svg class="-me-0.5 ms-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </template>
                                <template #content>
                                    <DropdownLink :href="route('profile.edit')">Profil</DropdownLink>
                                    <DropdownLink :href="route('logout')" method="post" as="button">
                                        Déconnexion
                                    </DropdownLink>
                                </template>
                            </Dropdown>
                        </div>
                    </div>

                    <!-- Hamburger Menu -->
                    <div class="-me-2 flex items-center sm:hidden">
                        <button @click="showingNavigationDropdown = !showingNavigationDropdown"
                            class="inline-flex items-center justify-center rounded-md p-2 text-white hover:bg-gray-200 hover:text-gray-500 focus:outline-none">
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path
                                    :class="{ hidden: showingNavigationDropdown, 'inline-flex': !showingNavigationDropdown }"
                                    stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16m-7 6h7" />
                                <path
                                    :class="{ hidden: !showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }"
                                    stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Responsive Navigation Menu -->
            <div :class="{ block: showingNavigationDropdown, hidden: !showingNavigationDropdown }" class="sm:hidden">
                <div class="space-y-1 pb-3 pt-2">
                    <ResponsiveNavLink :href="route('connected.homepage')"
                        :active="route().current('connected.homepage')">
                        Accueil
                    </ResponsiveNavLink>
                </div>

                <div class="space-y-1 pb-3 pt-2">
                    <ResponsiveNavLink :href="route('library')" :active="route().current('library')">
                        Votre Ludothèque
                    </ResponsiveNavLink>
                </div>

                <!-- Responsive Settings Options -->
                <div class="border-t border-gray-200 pb-1 pt-4">
                    <div class="px-4">
                        <div class="text-base font-medium text-gray-800">{{ $page.props.auth.user.name }}</div>
                    </div>

                    <div class="mt-3 space-y-1">
                        <ResponsiveNavLink :href="route('profile.edit')">Profile</ResponsiveNavLink>
                        <ResponsiveNavLink :href="route('logout')" method="post" as="button">
                            Log Out
                        </ResponsiveNavLink>
                    </div>
                </div>
            </div>
        </nav>

        <header v-if="$slots.header" class="py-4">
            <div class="text-center text-lg font-semibold text-gray-700">
                <slot name="header" />
            </div>
        </header>

        <main class="flex-grow">
            <div class="container mx-auto p-6">
                <slot />
            </div>
        </main>

        <footer class="bg-primary py-4 text-center text-secondary">
            <Footer />
        </footer>
    </div>
</template>
