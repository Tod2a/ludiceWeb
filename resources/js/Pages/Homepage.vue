<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head } from '@inertiajs/vue3';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
</script>

<template>
    <Head title="Bienvenue" />

    <GuestLayout>
        <template #header>
            <h2 class="font-pbold text-gray-800">
                Bienvenue sur Ludice
            </h2>
        </template>
        <div class="flex flex-col justify-center">
            <div class="bg-secondary rounded mx-auto py-10 px-8 flex flex-col items-center justify-center max-w-5xl space-y-4 flex-grow">
                <div class="font-pregular text-center">
                    <p>
                        Ludice est une application mobile en cours de développement, conçue pour enrichir vos soirées jeux de société.
                        Ce projet, issu d’un travail de fin d’études, vise à devenir l’outil incontournable des passionnés de jeux.
                    </p>
                    <p class="mt-2">
                        Dès maintenant, créez votre compte et commencez à construire votre ludothèque en ligne. Vous serez ainsi prêt à
                        profiter pleinement de toutes les fonctionnalités dès le lancement de l’application !
                    </p>
                    <p class="mt-2">
                        Au fil de son développement, Ludice proposera une multitude d’outils pour améliorer votre expérience ludique :
                        sélection aléatoire de jeux, gestion des scores, avis sur les jeux, et bien plus encore.
                    </p>
                    <p class="mt-2 font-bold">
                        Restez connectés, votre compagnon ludique arrive bientôt !
                    </p>
                </div>
            </div>
            <div class="flex justify-center">
                    <img src="/logo2.png" alt="Logo" class="transform scale-50" />
            </div>
        </div>

    </GuestLayout>
</template>
