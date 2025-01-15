<script setup>
import NavLink from './NavLink.vue';
import { Link } from '@inertiajs/vue3';
import SecondaryButton from './SecondaryButton.vue';
import DisabledButton from './DisabledButton.vue';
import DangerButton from './DangerButton.vue';

const props = defineProps({
    game: Object,
    isLibrary: Boolean,
    inLibrary: Boolean
});
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
        <div class="flex flex-wrap flex-col my-2 gap-2 items-center w-full">
            <!-- Bouton Détails -->
            <NavLink
                :href="route('connected.homepage')"
                class="w-full inline-flex items-center justify-center text-xs font-semibold text-indigo-600 hover:underline"
            >
                Détails
            </NavLink>

            <!-- Gestion dynamique des boutons -->
            <div class="w-full">
                <div v-if="props.inLibrary">
                    <div v-if="props.isLibrary">
                        <Link :href="route('connected.homepage')">
                            <DangerButton class="w-full text-center">
                                Retirer de la ludothèque
                            </DangerButton>
                        </Link>
                    </div>
                    <div v-else>
                        <!-- Bouton grisé et non cliquable -->
                        <DisabledButton class="w-full text-center">
                            Déjà dans la ludothèque
                        </DisabledButton>
                    </div>
                </div>
                <div v-else>
                    <Link :href="route('connected.homepage')">
                        <SecondaryButton class="w-full text-center">
                            Ajouter à la ludothèque
                        </SecondaryButton>
                    </Link>
                </div>
            </div>
        </div>
    </div>
</template>
