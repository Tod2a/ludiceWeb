<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';
import GameCard from '@/Components/GameCard.vue';

const props = defineProps({
    publishers: Array,
    categories: Array,
    creators: Array,
    user: Object,
});

const searchQuery = ref('');
const publisherQuery = ref('');
const categoryQuery = ref('');
const creatorQuery = ref('');
const games = ref([]);
const isLoading = ref(true);

const fetchGames = async (url) => {
    try {
        const response = await axios.get(url, {
            params: {
                query: searchQuery.value,
                category: categoryQuery.value,
                publisher: publisherQuery.value,
                creator: creatorQuery.value
            }
        });
        games.value = response.data;
    } catch (error) {
        console.error('Error fetching games:', error);
    }
};

const debouncedSearch = (() => {
    let timerId;
    return () => {
        clearTimeout(timerId);

        timerId = setTimeout(() => {
            fetchGames(route('games.search'));
        }, 300);
    };
})();

onMounted(async () => {
    await fetchGames(route('games.search'));
    isLoading.value = false;
});

const containsGameById = (id) => {
    return props.user.library.some((game) => game.id === id);
};

const clearInput = () => {
    searchQuery.value = '';
    debouncedSearch();
};
</script>

<template>
    <Head title="Accueil" />

    <AuthenticatedLayout>
        <div class="py-3">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="relative w-full max-w-md mx-auto">
                    <input
                    type="text"
                    v-model="searchQuery"
                    @input="debouncedSearch"
                    placeholder="Recherchez par nom"
                    class="border rounded p-2 w-full pr-10"
                    />
                    <!-- Icône de suppression -->
                    <button
                    v-if="searchQuery"
                    @click="clearInput"
                    class="absolute top-1/2 right-2 transform -translate-y-1/2 text-gray-500"
                    >
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    </button>
                </div>
                <!-- Loading Indicator -->
                <div v-if="isLoading" class="text-center text-gray-500 py-6">
                    Chargement...
                </div>

                <!-- Game Cards -->
                <div v-else class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    <GameCard
                        v-for="game in games.data"
                        :key="game.id"
                        :game="game"
                        :isLibrary="false"
                        :inLibrary="containsGameById(game.id)"
                    />
                </div>

                <!-- Pagination -->
                <div v-if="!isLoading" class="mt-6 flex justify-center items-center space-x-4">
                    <button
                        id="fetchprev"
                        @click="fetchGames(games.prev_page_url)"
                        v-if="games.prev_page_url"
                        class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300 transition"
                    >
                        &lt; Previous
                    </button>
                    <span>Page {{ games.current_page }} of {{ games.last_page }}</span>
                    <button
                        id="fetchnext"
                        @click="fetchGames(games.next_page_url)"
                        v-if="games.next_page_url"
                        class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300 transition"
                    >
                        Next &gt;
                    </button>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
