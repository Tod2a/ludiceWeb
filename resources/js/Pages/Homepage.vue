<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>

    <Head title="Bienvenue">
        <meta name="description"
            content="Ludice est une application mobile pour enrichir vos soirées jeux de société : tirages aléatoires, scores, avis et plus." />

        <!-- Open Graph pour Facebook, LinkedIn, etc. -->
        <meta property="og:title" content="Ludice - L'application pour votre ludothèque" />
        <meta property="og:description"
            content="Trouvez le jeu idéal, gérez votre ludothèque, et partagez vos scores entre amis avec Ludice." />
        <meta property="og:url" content="https://ludice.app" />
        <meta property="og:type" content="website" />
        <meta property="og:image" content="https://ludice.app/logo.png" />

        <!-- Twitter Card -->
        <meta name="twitter:card" content="summary_large_image" />
        <meta name="twitter:title" content="Ludice - L'application pour vos votre ludothèque" />
        <meta name="twitter:description"
            content="Trouvez le jeu idéal, gérez votre ludothèque, et partagez vos scores entre amis avec Ludice." />
        <meta name="twitter:image" content="https://ludice.app/logo.png" />

    </Head>
    <GuestLayout>
        <template #header>
            <h1 class="text-3xl font-extrabold tracking-tight">
                Ludice - Votre Application Mobile pour Gérer et Profiter de Votre Ludothèque et de Vos Jeux de Société
            </h1>
        </template>

        <div
            class="flex flex-col md:flex-row max-w-4xl mx-auto bg-white rounded-lg shadow-md overflow-hidden mt-8 p-6 space-y-6 md:space-y-0 md:space-x-8 mb-8">
            <div class="flex-1 flex flex-col justify-center">
                <h3 class="text-2xl font-semibold text-gray-800 mb-4">Une expérience Mobile</h3>
                <p class="text-gray-700 mb-4 leading-relaxed">
                    Ludice, notre application mobile innovante, est conçue pour enrichir vos soirées jeux de société.
                    Développée avec passion, elle vise à devenir l’outil incontournable des passionnés de jeux.
                </p>
                <p class="text-gray-700 mb-4 leading-relaxed">
                    Cette interface simple, rapide et intuitive vous permettra d’accéder facilement à votre compte
                    Ludice
                    et de profiter pleinement de toutes les fonctionnalités.
                </p>
                <p class="text-gray-700 mb-4 leading-relaxed">
                    Téléchargez notre application sur le Play Store et révolutionnez vos
                    soirées ludiques dès maintenant !
                </p>
                <p class="text-gray-600 italic">
                    Disponible sur iOS très bientôt !
                </p>
            </div>
            <div class="flex-shrink-0 w-full md:w-48 h-auto">
                <img src="storage/images/homepage/login-mobile.png"
                    alt="Capture d'écran de la page de connexion mobile de Ludice"
                    class="rounded-lg object-cover w-full h-auto" />
            </div>
        </div>

        <div
            class="flex flex-col md:flex-row max-w-4xl mx-auto bg-white rounded-lg shadow-md overflow-hidden mt-8 p-6 space-y-6 md:space-y-0 md:space-x-8 mb-8">
            <div class="flex-shrink-0 w-full md:w-64 h-auto">
                <img src="storage/images/homepage/web-home.png" alt="Capture d'écran de la page d'accueil web de Ludice"
                    class="rounded-lg object-cover w-full h-auto" />
            </div>
            <div class="flex-1 flex flex-col justify-center">
                <h3 class="text-2xl font-semibold text-gray-800 mb-4">Créez votre compte Ludice</h3>
                <p class="text-gray-700 mb-4 leading-relaxed">
                    Accédez à une base de données ludique en constante évolution, avec déjà plus de 500 jeux de société
                    référencés. Découvrez, explorez et enrichissez votre propre collection en quelques clics.

                </p>
                <p class="text-gray-700 leading-relaxed">
                    Dès maintenant, créez votre compte et commencez à construire votre ludothèque en ligne sur notre
                    page web.
                    Vous serez
                    ainsi prêt à
                    profiter pleinement de toutes les fonctionnalités de l’application !
                </p>
            </div>
        </div>

        <div
            class="flex flex-col md:flex-row max-w-4xl mx-auto bg-white rounded-lg shadow-md overflow-hidden mt-8 p-6 space-y-6 md:space-y-0 md:space-x-8 mb-8">
            <div class="flex-1 flex flex-col justify-center">
                <h3 class="text-2xl font-semibold text-gray-800 mb-4">
                    Une application pensée pour les joueurs
                </h3>
                <p class="text-gray-700 mb-4 leading-relaxed">
                    Enregistrez vos scores, choisissez le jeu idéal pour votre soirée, désignez le premier joueur,
                    consultez
                    l’historique de vos parties, gérez votre ludothèque et accédez aux détails complets de chaque jeu.
                    Notre
                    application mobile Ludice est conçue pour répondre aux besoins des passionnés de jeux de société.
                </p>
                <p class="text-gray-700 mb-4 leading-relaxed">
                    En constante évolution, de nouvelles fonctionnalités arrivent très bientôt : une liste d’amis pour
                    suivre et
                    enregistrer vos scores entre ludistes, une wishlist personnalisée, et bien plus encore !
                </p>
                <p class="text-gray-700 font-semibold">
                    Restez connectés, l'aventure ludique ne fait que commencer 🚀
                </p>
            </div>
            <div class="flex-shrink-0 w-full md:w-64 h-auto">
                <img src="storage/images/homepage/feature-preview.png"
                    alt="Aperçu des fonctionnalités de l'application mobile Ludice"
                    class="rounded-lg object-cover w-full h-auto" />
            </div>
        </div>

        <div class="mt-6 flex justify-center">
            <img src="/logo.png" alt="Logo" class="h-20 w-auto" />
        </div>
    </GuestLayout>
</template>
