<script setup>
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const props = defineProps({
    appStartWeek: Number,
    appStartMonth: Number,
    selectedGameWeek: Number,
    selectedGameMonth: Number,
    totalGames: Number,
    verifiedUsers: Number,
})
</script>

<template>

    <Head title="Admin Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-2xl font-semibold">
                Dashboard
            </h2>
        </template>

        <div class="space-y-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                <div class="bg-white shadow rounded-lg p-6 flex flex-col justify-center items-center">
                    <h3 class="text-lg font-medium text-gray-700 mb-2">Nombre total d'inscrits</h3>
                    <p class="text-3xl font-bold text-green-600">{{ verifiedUsers }}</p>
                </div>

                <div class="bg-white shadow rounded-lg p-6 flex flex-col justify-center items-center">
                    <h3 class="text-lg font-medium text-gray-700 mb-2">Nombre total de jeux</h3>
                    <p class="text-3xl font-bold text-green-600">{{ totalGames }}</p>
                </div>

                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-700 mb-2">Les Ludistes ont ouvert notre application
                    </h3>
                    <p class="text-green-600 font-semibold text-xl">
                        {{ appStartWeek }} fois cette semaine
                    </p>
                    <p class="text-green-600 font-semibold text-xl">
                        {{ appStartMonth }} fois ce mois-ci
                    </p>
                </div>

                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-700 mb-2">Nous avons aidé à choisir le jeu de la soirée
                    </h3>
                    <p class="text-green-600 font-semibold text-xl">
                        {{ selectedGameWeek }} fois cette semaine
                    </p>
                    <p class="text-green-600 font-semibold text-xl">
                        {{ selectedGameMonth }} fois ce mois-ci
                    </p>
                </div>
            </div>

            <div class="bg-green-50 border border-green-300 rounded-lg p-6 text-center">
                <p class="text-green-900 text-lg font-medium">
                    Merci pour votre travail et votre implication dans le projet, nous construisons ensemble le
                    compagnon parfait de nos soirées ludiques.
                </p>
            </div>

        </div>

    </AuthenticatedLayout>
</template>
