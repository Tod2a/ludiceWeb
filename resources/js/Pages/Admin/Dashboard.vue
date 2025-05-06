<script setup>
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
</script>

<template>

    <Head title="Admin Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-2xl font-semibold">
                Dashboard
            </h2>
        </template>
        <div class="bg-white shadow-md rounded-lg p-8">
            <p class="text-gray-700 leading-relaxed">
                Bienvenue sur votre dashboard. En tant qu’administrateur, votre rôle est de veiller à ce que la base de
                données de Ludice reste à jour. Le système est encore en cours de développement, mais vous avez déjà
                accès à la gestion des jeux.
            </p>
            <p class="text-gray-700 leading-relaxed mt-4">
                Merci pour votre travail et votre implication dans le projet !
            </p>
        </div>
    </AuthenticatedLayout>
</template>
