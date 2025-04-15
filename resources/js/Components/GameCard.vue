<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue'
import { Link, useForm } from '@inertiajs/vue3';

const form = useForm({});

const props = defineProps({
    game: Object,
    isLibrary: Boolean,
    inLibrary: Boolean
});

const menuOpen = ref(false);
const menuRef = ref(null);

const handleClickOutside = (event) => {
    if (menuRef.value && !menuRef.value.contains(event.target)) {
        menuOpen.value = false;
    }
}

onMounted(() => {
    document.addEventListener('click', handleClickOutside);
});

onBeforeUnmount(() => {
    document.removeEventListener('click', handleClickOutside);
});
</script>

<template>
    <div class="bg-white rounded-lg p-3 shadow-md hover:shadow-lg transition-shadow flex flex-col overflow-hidden items-center">
        <div class="mb-2 flex flex-col w-full">
            <div class="flex justify-between items-center">
                <h3 class="text-lg font-semibold truncate">{{ props.game.name }}</h3>

                <div class="relative inline-block text-left" ref="menuRef">
                    <button @click="menuOpen = !menuOpen" type="button" class="p-2 rounded-full hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <svg class="h-5 w-5 text-gray-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v.01M12 12v.01M12 18v.01" />
                        </svg>
                    </button>

                    <div v-if="menuOpen" class="absolute right-0 mt-2 w-48 origin-top-right rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-10">
                        <div class="py-1">
                            <Link :href="route('games.details', {gameId: props.game.id})" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                Détails
                            </Link>

                            <div class="border-t border-gray-200"></div>

                            <template v-if="props.inLibrary">
                                <template v-if="props.isLibrary">
                                    <form @submit.prevent="form.delete(route('library.destroy', { game: props.game.id }))">
                                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                            Retirer de la ludothèque
                                        </button>
                                    </form>
                                </template>
                                <template v-else>
                                    <button disabled class="block w-full text-left px-4 py-2 text-sm text-gray-400">
                                        Déjà dans la ludothèque
                                    </button>
                                </template>
                            </template>

                            <template v-else>
                                <form @submit.prevent="form.post(route('library.store', { game: props.game.id }))">
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-indigo-600 hover:bg-gray-100">
                                        Ajouter à la ludothèque
                                    </button>
                                </form>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="relative pb-2/3 w-full">
            <img
                :src="props.game.img_path"
                :alt="'Image ' + props.game.name"
                class="rounded-lg bg-gray-100 w-full"
            />
        </div>
    </div>
</template>
