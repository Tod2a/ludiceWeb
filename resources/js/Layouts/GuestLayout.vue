<script setup>
import { ref } from 'vue';
import { Head } from '@inertiajs/vue3';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Footer from '../Components/Footer.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link } from '@inertiajs/vue3';

const showingNavigationDropdown = ref(false);
</script>

<template>
    <Head>
        <link rel="icon" href="/favicon.ico" />
    </Head>
    <div class="bg-white-100 min-h-screen flex flex-col">
        <!-- Header -->
        <nav class="bg-primary shadow-md border-b border-gray-100">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 justify-between">
                    <div class="flex items-center">
                        <!-- Logo -->
                        <Link href="/">
                            <ApplicationLogo class="h-16 w-16 scale-75" />
                        </Link>
                    </div>

                    <!-- Navigation Links -->
                    <div class="hidden sm:flex sm:items-center sm:space-x-4">
                        <Link v-if="$page.props.auth.user" :href="route('dashboard')">
                            <PrimaryButton>Dashboard</PrimaryButton>
                        </Link>
                        <div v-else class="flex space-x-4">
                            <Link :href="route('login')">
                                <PrimaryButton>Connexion</PrimaryButton>
                            </Link>
                            <Link :href="route('register')">
                                <PrimaryButton>Inscription</PrimaryButton>
                            </Link>
                        </div>
                    </div>

                    <!-- Hamburger Menu -->
                    <div class="-me-2 flex items-center sm:hidden">
                        <button
                            @click="showingNavigationDropdown = !showingNavigationDropdown"
                            class="inline-flex items-center justify-center rounded-md p-2 text-white focus:outline-none hover:bg-gray-200 hover:text-gray-500"
                        >
                            <svg
                                class="h-6 w-6"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    :class="{
                                        hidden: showingNavigationDropdown,
                                        'inline-flex': !showingNavigationDropdown,
                                    }"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M4 6h16M4 12h16m-7 6h7"
                                />
                                <path
                                    :class="{
                                        hidden: !showingNavigationDropdown,
                                        'inline-flex': showingNavigationDropdown,
                                    }"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"
                                />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Responsive Navigation Menu -->
            <div
                :class="{ block: showingNavigationDropdown, hidden: !showingNavigationDropdown }"
                class="sm:hidden"
            >
                <div class="space-y-1 pb-3 pt-2">
                    <ResponsiveNavLink
                        v-if="$page.props.auth.user"
                        :href="route('dashboard')"
                    >
                        Dashboard
                    </ResponsiveNavLink>
                    <div v-else class="space-y-1">
                        <ResponsiveNavLink :href="route('login')">
                            Connexion
                        </ResponsiveNavLink>
                        <ResponsiveNavLink :href="route('register')">
                            Inscription
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
