<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import { FwbModal } from 'flowbite-vue';
import { onMounted, ref } from 'vue';
import { TrashIcon, PencilIcon } from '@heroicons/vue/24/outline';
import NavLink from '@/Components/NavLink.vue';
import { initFlowbite } from 'flowbite';

const searchName = ref('');
const games = ref([]);

const fetchGames = async (url) => {
    const response = await axios.get(url, {
        params: {
            name: searchName.value
        },
    });
    games.value = response.data;
}

const debouncedSearch = (() => {
    let timerId;
    return () => {
        clearTimeout(timerId);

        timerId = setTimeout(() => {
            fetchGames(route('admin.games.search'));
        }, 300);
    };
})();

onMounted(() => {
    debouncedSearch();
})
</script>


<template>

    <Head title="Admin" />

    <AuthenticatedLayout>

        <template #header>
            <h2 class="text-2xl font-semibold">
                Gestion des jeux
            </h2>
        </template>

        <div class="bg-white shadow-md rounded-lg p-8">
            <div class="flex justify-center py-1">
                <input type="text" v-model="searchName" @input="debouncedSearch" placeholder="Search by name" />
            </div>

            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr class="uppercase text-left">
                            <th class="px-4 py-2 border">nom</th>
                            <th class="px-4 py-2 border">actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="game in games.data" :key="game.id"
                            class="hover:bg-gray-50 odd:bg-gray-100 hover:odd:bg-gray-200 transition">
                            <td class="border px-4 py-2"> {{ game.name }}</td>
                            <td class="border px-4 py-2 space-x-4">
                                <div class="flex space-x-4">
                                    <!-- <Button @click="openEditModal(user.id, user.name, user.role.id)">
                                        <PencilIcon class="w-5 h-5 text-blue-500" />
                                    </Button> -->
                                    <!-- <Button :disabled="true" @click="confirmUserDeletion(user.id, user.name)">
                                        <TrashIcon class="w-5 h-5 text-red-400" />
                                    </Button> -->
                                </div>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4" class="px-6">
                                <button @click="fetchGames(games.prev_page_url)" v-if="games.prev_page_url">&lt;
                                    Previous</button>
                                Page {{ games.current_page }} of {{ games.last_page }}
                                <button @click="fetchGames(games.next_page_url)" v-if="games.next_page_url">Next
                                    &gt;</button>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </AuthenticatedLayout>

</template>
