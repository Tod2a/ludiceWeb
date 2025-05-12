<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';

const props = defineProps({
    game: Object,
});

</script>

<template>

    <Head title="game detail" />

    <AuthenticatedLayout>

        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                <h1 class="text-3xl font-bold mb-6 text-center">{{ game.name }}</h1>

                <div class="flex flex-col md:flex-row bg-white shadow-sm rounded-lg overflow-hidden">

                    <div class="md:w-1/2 flex justify-center items-center p-4">
                        <div class="relative w-full max-w-xs aspect-square overflow-hidden rounded-lg bg-gray-100">
                            <img :src="game.img_path" :alt="'Image of ' + game.name"
                                class="object-cover w-full h-full" />
                        </div>
                    </div>

                    <div class="md:w-1/2 p-6">
                        <div class="mb-4">
                            <p><strong>Joueurs:</strong> {{ game.min_players }} - {{ game.max_players }}</p>
                            <p><strong>Durée:</strong> {{ game.average_duration }} minutes</p>
                            <p><strong>Âge:</strong> {{ game.suggestedage }}+</p>
                            <p><strong>Date de parution:</strong> {{ new Date(game.published_at).toLocaleDateString() }}
                            </p>
                            <p><strong>Stand Alone:</strong> {{ game.is_expansion ? 'Non' : 'Oui' }}</p>
                        </div>
                        <div class="mb-4">
                            <p><strong>Catégories:</strong> {{game.categories.map(c => c.name).join(', ')}}</p>
                            <p><strong>Mécaniques:</strong> {{game.mechanics.map(m => m.name).join(', ')}}</p>
                            <p><strong>Éditeurs:</strong> {{game.publishers.map(p => p.name).join(', ')}}</p>
                            <p><strong>Créateurs:</strong> {{game.creators.map(c => c.firstname + ' ' +
                                c.lastname).join(', ')}}</p>
                        </div>
                    </div>
                </div>

                <div class="mt-6 bg-white shadow-sm rounded-lg p-6">
                    <h2 class="text-xl font-semibold mb-2">Description</h2>
                    <p>{{ game.description }}</p>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>
