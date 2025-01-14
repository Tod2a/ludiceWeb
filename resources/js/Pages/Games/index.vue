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

const fetchGames = async(url) => {
    const response = await axios.get(url, {
        params: {
            query: searchQuery.value,
            category: categoryQuery.value,
            publisher: publisherQuery.value,
            creator: creatorQuery.value
        }
    });

    games.value = response.data;
}

const debouncedSearch = (() => {
    let timerId;
    return () => {
        clearTimeout(timerId);

        timerId = setTimeout(() => {
            fetchGames(route('games.search'));
        }, 300);
    };
})();

onMounted(() => {
    debouncedSearch();
})

console.log()
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                <GameCard v-for="game in games.data" :key="game.id" :game="game" />
            </div>

            <div class="mt-6 flex justify-center items-center space-x-4">
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
