<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Bienvenue" />
    <GuestLayout>
        <template #header>
            <h2 class="text-2xl font-semibold">
                Bienvenue sur Ludice
            </h2>
        </template>
        <div class="bg-white shadow-md rounded-lg p-8">
            <p class="text-gray-700 leading-relaxed">
                Ludice est une application mobile en cours de développement, conçue pour enrichir vos soirées jeux de société.
                Ce projet, issu d’un travail de fin d’études, vise à devenir l’outil incontournable des passionnés de jeux.
            </p>
            <p class="mt-4 text-gray-700 leading-relaxed">
                Dès maintenant, créez votre compte et commencez à construire votre ludothèque en ligne. Vous serez ainsi prêt à
                profiter pleinement de toutes les fonctionnalités dès le lancement de l’application !
            </p>
            <p class="mt-4 text-gray-700 leading-relaxed">
                Au fil de son développement, Ludice proposera une multitude d’outils pour améliorer votre expérience ludique :
                sélection aléatoire de jeux, gestion des scores, avis sur les jeux, et bien plus encore.
            </p>
            <p class="mt-4 font-bold text-gray-900">
                Restez connectés, votre compagnon ludique arrive bientôt !
            </p>
        </div>
        <div class="mt-6 flex justify-center">
            <img src="/logo2.png" alt="Logo" class="h-20 w-auto" />
        </div>
    </GuestLayout>
</template>
