<script setup>
import { ref, computed } from 'vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { onClickOutside } from '@vueuse/core';
import { FwbModal } from 'flowbite-vue';
import ToastList from '@/Components/ToastList.vue';
import { usePage, router } from '@inertiajs/vue3';
import Footer from '@/Components/Footer.vue';
import { Link } from '@inertiajs/vue3';
import PolicyModal from '@/Components/PolicyModal.vue';

const isSidebarOpen = ref(false);
const showingNavigationDropdown = ref(false);
const isDropdownAdminOpen = ref(false);

const sidebarRef = ref(null);
const toggleButtonRef = ref(null);

const mobileProfileMenu = ref(null);
const closeMobileMenuButton = ref(null);

const showModal = computed(() => {
    const page = usePage();
    const user = page.props.auth.user;
    const url = page.url.toLowerCase();

    return user && !user.policy_accepted && !url.includes('privacy-policy');
});
function acceptPolicy() {
    router.put(route('user.accept-policy'))
}

function refusePolicy() {
    router.post(route('logout'));
}

onClickOutside(sidebarRef, (event) => {
    if (!toggleButtonRef.value.contains(event.target)) {
        isSidebarOpen.value = false;
    }
});

onClickOutside(mobileProfileMenu, (event) => {
    if (!closeMobileMenuButton.value.contains(event.target)) {
        showingNavigationDropdown.value = false;
    }
});
</script>

<template>
    <div class="bg-white-100 dark:bg-white-100 min-h-screen flex flex-col overflow-x-hidden">

        <!-- Header -->
        <nav class="fixed top-0 left-0 w-full z-50 bg-primary shadow-md border-b border-gray-100">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="relative flex h-16 justify-between">

                    <button ref="toggleButtonRef" @click="isSidebarOpen = !isSidebarOpen"
                        class="text-white focus:outline-none">
                        <!-- Icône du menu -->
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>

                    <div class="absolute left-1/2 top-0 h-16 flex items-center transform -translate-x-1/2">
                        <Link :href="route('connected.homepage')" class="flex items-center">
                        <img src="/storage/images/ludice.png" alt="Ludice"
                            class="h-10 md:h-12 lg:h-14 object-contain transition-transform duration-200 hover:scale-105" />
                        </Link>
                    </div>

                    <!-- Navigation Links -->
                    <div class="hidden sm:flex sm:items-center sm:space-x-4">
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
                            ref="closeMobileMenuButton"
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
            <div :class="{ block: showingNavigationDropdown, hidden: !showingNavigationDropdown }" class="sm:hidden"
                ref="mobileProfileMenu">

                <!-- Responsive Settings Options -->
                <div class="border-t border-gray-200 pb-1 pt-4">
                    <div class="px-4">
                        <div class="text-base font-medium text-gray-400">{{ $page.props.auth.user.name }}</div>
                    </div>

                    <div class="mt-3 space-y-1">
                        <ResponsiveNavLink :href="route('profile.edit')">Profil</ResponsiveNavLink>
                        <ResponsiveNavLink :href="route('logout')" method="post" as="button">
                            Déconnexion
                        </ResponsiveNavLink>
                    </div>
                </div>
            </div>
        </nav>

        <div class="flex mt-16 flex-1">

            <ToastList />

            <!-- Sidebar -->
            <aside ref="sidebarRef" :class="[
                'fixed top-0 left-0 h-full bg-green-800 text-white transition-transform duration-300 z-40 mt-16',
                isSidebarOpen ? 'translate-x-0 w-64' : '-translate-x-full w-64'
            ]">

                <div class="p-4">
                    <!-- Contenu de la sidebar -->
                    <ul class="space-y-2 font-medium">
                        <li>
                            <a :href="route('connected.homepage')"
                                class="flex items-center p-2 text-white rounded-lg dark:text-white hover:bg-green-200 dark:hover:text-primary dark:hover:bg-green-200 group">
                                <span class="ms-3">Accueil</span>
                            </a>
                        </li>
                        <li v-show="$page.props.auth.user.role.name && $page.props.auth.user.role.name !== 'User'">

                            <button @click="isDropdownAdminOpen = !isDropdownAdminOpen" type="button"
                                class="flex items-center w-full text-white p-2 text-base transition duration-75 rounded-lg group hover:bg-green-200 dark:text-white dark:hover:text-primary dark:hover:bg-green-200">
                                <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">Admin</span>
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 10 6">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 1 4 4 4-4" />
                                </svg>
                            </button>
                            <ul v-show="isDropdownAdminOpen" class="py-2 space-y-2">
                                <li>
                                    <a :href="route('admin.dashboard')"
                                        class="flex items-center p-2 text-white rounded-lg dark:text-white hover:bg-green-200 dark:hover:text-primary dark:hover:bg-green-200 group">
                                        <span class="ms-3">Tableau de bord</span>
                                    </a>
                                    <a :href="route('users.index')"
                                        class="flex items-center p-2 text-white rounded-lg dark:text-white hover:bg-green-200 dark:hover:text-primary dark:hover:bg-green-200 group"
                                        v-if="$page.props.auth.user.role.name === 'Master'">
                                        <span class="ms-3">Utilisateurs</span>
                                    </a>
                                    <a :href="route('games.index')"
                                        class="flex items-center p-2 text-white rounded-lg dark:text-white hover:bg-green-200 dark:hover:text-primary dark:hover:bg-green-200 group">
                                        <span class="ms-3">Jeux</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a :href="route('library')"
                                class="flex items-center p-2 text-white rounded-lg dark:text-white hover:bg-green-200 dark:hover:text-primary dark:hover:bg-green-200 group">
                                <span class="ms-3">Ludothèque</span>
                            </a>
                            <a :href="route('wishlist')"
                                class="flex items-center p-2 text-white rounded-lg dark:text-white hover:bg-green-200 dark:hover:text-primary dark:hover:bg-green-200 group">
                                <span class="ms-3">Liste de souhaits</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </aside>

            <!-- Contenu principal -->
            <div :class="[
                'flex-1 transition-all duration-300 flex flex-col',
                isSidebarOpen ? 'ml-64' : 'ml-0'
            ]">
                <header v-if="$slots.header" class="py-4">
                    <div class="text-center text-lg font-semibold text-gray-700">
                        <slot name="header" />
                    </div>
                </header>


                <main class="p-6 w-screen flex-1 overflow-auto">
                    <slot />
                </main>

                <Footer />

                <PolicyModal :show="showModal" @accept="acceptPolicy" @refuse="refusePolicy" />
            </div>
        </div>
    </div>
</template>
