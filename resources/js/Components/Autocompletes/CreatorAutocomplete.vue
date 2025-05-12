<script setup>
import { ref } from 'vue';
import axios from 'axios';
import debounce from 'lodash/debounce';

const emit = defineEmits(['add-creator']);

const search = ref('');
const suggestions = ref([]);
const showSuggestions = ref(false);

const fetchSuggestions = debounce(async (query) => {
    if (query.length < 2) {
        suggestions.value = [];
        showSuggestions.value = false;
        return;
    }
    try {
        const response = await axios.get(route('creator.search'), {
            params: { name: query },
        });
        suggestions.value = response.data.data;
        showSuggestions.value = true;
    } catch (error) {
        console.error('Error fetching creators:', error);
    }
}, 300);

const onInput = () => {
    fetchSuggestions(search.value);
};

const selectCreator = (creator) => {
    emit('add-creator', creator);
    search.value = '';
    suggestions.value = [];
    showSuggestions.value = false;
};
</script>

<template>
    <div class="relative">
        <input type="text" v-model="search" @input="onInput" placeholder="Rechercher un createur"
            class="w-full border border-gray-300 rounded-lg p-2.5 text-sm focus:ring-blue-500 focus:border-blue-500" />
        <ul v-if="suggestions.length && showSuggestions"
            class="absolute z-10 w-full bg-white border border-gray-300 rounded-lg mt-1 max-h-60 overflow-auto">
            <li v-for="creator in suggestions" :key="creator.id" @click="selectCreator(creator)"
                class="px-4 py-2 hover:bg-gray-100 cursor-pointer">
                {{ creator.firstname }} {{ creator.lastname }}
            </li>
        </ul>
    </div>
</template>
