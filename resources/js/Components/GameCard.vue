<script setup>
import NavLink from './NavLink.vue';
import { Link } from '@inertiajs/vue3';
import SecondaryButton from './SecondaryButton.vue';

const props = defineProps({
    game: Object,
    inLibrary: Boolean
})

</script>

<template>
    <div class="bg-white rounded-lg p-3 shadow-md hover:shadow-lg transition-shadow flex flex-col overflow-hidden items-center">
        <div class="mb-2 flex flex-col">
            <h3 class="text-lg font-semibold truncate">{{ props.game.name }}</h3>
        </div>
        <div class="relative pb-2/3">
            <img
                :src="props.game.img_path"
                :alt="'Image ' + props.game.name"
                class="rounded-lg bg-gray-100"
            />
        </div>
        <div class="flex flex-wrap flex-col my-2 gap-2 items-center">
            <NavLink
                :href="route('connected.homepage')"
                class="flex-1 inline-flex items-center text-xs font-semibold text-indigo-600 hover:underline"
            >
                Détails
            </NavLink>
            <div v-if="inLibrary">
                <Link :href="route('connected.homepage')">
                    <SecondaryButton class="flex-2 text-wrap w-full text-center">
                        Retirer de la ludothèque
                    </SecondaryButton>
                </Link>
            </div>
            <div v-else>
                <Link :href="route('connected.homepage')">
                    <SecondaryButton class="flex-2 text-wrap w-full text-center">
                        Ajouter à la ludothèque
                    </SecondaryButton>
                </Link>
            </div>
        </div>
    </div>
</template>
