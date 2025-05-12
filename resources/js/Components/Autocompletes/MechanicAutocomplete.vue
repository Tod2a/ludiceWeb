<script setup>
import { ref } from 'vue';
import axios from 'axios';
import debounce from 'lodash/debounce';

const emit = defineEmits(['add-mechanic']);

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
        const response = await axios.get(route('mechanic.search'), {
            params: { name: query },
        });
        suggestions.value = response.data.data;
        showSuggestions.value = true;
    } catch (error) {
        console.error('Error fetching mechanics:', error);
    }
}, 300);

const onInput = () => {
    fetchSuggestions(search.value);
};

const selectMechanic = (mechanic) => {
    emit('add-mechanic', mechanic);
    search.value = '';
    suggestions.value = [];
    showSuggestions.value = false;
};
</script>

<template>
    <div class="relative">
        <input type="text" v-model="search" @input="onInput" placeholder="Rechercher une mécanique"
            class="w-full border border-gray-300 rounded-lg p-2.5 text-sm focus:ring-blue-500 focus:border-blue-500" />
        <ul v-if="suggestions.length && showSuggestions"
            class="absolute z-10 w-full bg-white border border-gray-300 rounded-lg mt-1 max-h-60 overflow-auto">
            <li v-for="mechanic in suggestions" :key="mechanic.id" @click="selectMechanic(mechanic)"
                class="px-4 py-2 hover:bg-gray-100 cursor-pointer">
                {{ mechanic.name }}
            </li>
        </ul>
    </div>
</template>
