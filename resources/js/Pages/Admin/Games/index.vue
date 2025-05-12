<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import { FwbModal } from 'flowbite-vue';
import { onMounted, ref } from 'vue';
import { TrashIcon, PencilIcon } from '@heroicons/vue/24/outline';
import NavLink from '@/Components/NavLink.vue';

const searchName = ref('');
const games = ref([]);
const user = usePage().props.auth.user;

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

const form = useForm({
    id: null,
    name: null,
})

const isDeleteModalVisible = ref(false);

const openDeleteModal = (id, name) => {
    form.id = id;
    form.name = name;
    isDeleteModalVisible.value = true;
}

const deleteGame = () => {
    form.delete(route('games.destroy', form.id), {
        onSuccess: () => closeDeleteModal(),
    })
}

const closeDeleteModal = () => {
    isDeleteModalVisible.value = false;
    form.reset();
    debouncedSearch();
}

const clearInput = () => {
    searchName.value = '';
    debouncedSearch();
};

</script>


<template>

    <Head title="Admin" />

    <AuthenticatedLayout>

        <template #header>
            <h2 class="text-2xl font-semibold">
                Gestion des jeux
            </h2>
        </template>
        <div class="px-8">

            <div class="flex items-center justify-between gap-4 mb-1">
                <div class="relative w-full max-w-md">
                    <input type="text" v-model="searchName" @input="debouncedSearch" placeholder="Recherchez par nom"
                        class="border rounded p-2 w-full pr-10" />
                    <button v-if="searchName" @click="clearInput"
                        class="absolute top-1/2 right-2 transform -translate-y-1/2 text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <NavLink :href="route('games.create')"
                    class="p-2 bg-gray-300 rounded-lg hover:bg-gray-400 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                </NavLink>
            </div>

            <div class="relative overflow-x-auto shadow-md sm:rounded-lg bg-white">
                <table class="w-full text-left rtl:text-right text-gray-500 dark:text-primary">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr class="uppercase text-left">
                            <th class="px-4 py-2 border">nom</th>
                            <th class="px-4 py-2 border">Date de publication</th>
                            <th class="px-4 py-2 border">Maison d'édition</th>
                            <th class="px-4 py-2 border">Créateurs</th>
                            <th class="px-4 py-2 border w-2">Joueurs min</th>
                            <th class="px-4 py-2 border w-2">Joueurs max</th>
                            <th class="px-4 py-2 border">Durée</th>
                            <th class="px-4 py-2 border">Age</th>
                            <td class="px-4 py-2 border">EAN</td>
                            <th class="px-4 py-2 border w-2">actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="game in games.data" :key="game.id"
                            class="odd:bg-white even:bg-gray-100 hover:bg-gray-200 transition">
                            <td class="border px-4 py-2"> {{ game.name }}</td>
                            <td class="border px-4 py-2"> {{ game.published_at }}</td>
                            <td class="border px-4 py-2"> <span v-for="publisher in game.publishers"
                                    :key="publisher.id">{{
                                        publisher.name }}</span>
                            </td>
                            <td class="border px-4 py-2"> <span v-for="creator in game.creators" :key="creator.id">{{
                                creator.firstname }} {{ creator.lastname }}</span>
                            </td>
                            <td class="border px-4 py-2"> {{ game.min_players }}</td>
                            <td class="border px-4 py-2"> {{ game.max_players }}</td>
                            <td class="border px-4 py-2"> {{ game.average_duration }} min</td>
                            <td class="border px-4 py-2"> {{ game.suggestedage }}</td>
                            <td class="border px-4 py-2"> {{ game.EAN }}</td>
                            <td class="border px-4 py-2 space-x-4">
                                <div class="flex space-x-4">
                                    <Link :href="route('games.edit', game.id)">
                                    <PencilIcon class="w-5 h-5 text-blue-500" />
                                    </Link>
                                    <button :disabled="user.role.name !== 'Master'"
                                        @click="openDeleteModal(game.id, game.name)">
                                        <TrashIcon class="w-5 h-5"
                                            :class="user.role.name !== 'Master' ? 'text-gray-400' : 'text-red-400'" />
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4" class="px-6 py-4">
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

            <FwbModal size="md" position="top-center" v-if="isDeleteModalVisible" @close="closeDeleteModal">
                <template #header>
                    <h2>Êtes-vous sûr de vouloir supprimer le jeu {{ form.name }}</h2>
                </template>
                <template #body>
                    <p class="text-sm text-gray-500">
                        Cette action est irréversible.
                    </p>
                </template>
                <template #footer>
                    <button @click="closeDeleteModal"
                        class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5">
                        Annuler
                    </button>
                    <button @click="deleteGame"
                        class="text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5">
                        Supprimer
                    </button>
                </template>
            </FwbModal>
        </div>
    </AuthenticatedLayout>

</template>
