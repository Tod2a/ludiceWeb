<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';
import GameCard from '@/Components/GameCard.vue';

const props = defineProps({
    publishers: Array,
    categories: Array,
    creators: Array,
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
</script>

<template>
    <Head title="Accueil" />

    <AuthenticatedLayout>
        <div class="py-3">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="py-2 text-center">
                    <input
                        type="text"
                        id="namesearch"
                        v-model="searchQuery"
                        @input="debouncedSearch"
                        placeholder="Recherchez par nom"
                        class="border rounded p-2 w-full max-w-md"
                    />
                </div>

                <!-- Loading Indicator -->
                <div v-if="isLoading" class="text-center text-gray-500 py-6">
                    Chargement...
                </div>

                <!-- Game Cards -->
                <div v-else class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    <GameCard v-for="game in games.data" :key="game.id" :game="game" :in-library="false" />
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
