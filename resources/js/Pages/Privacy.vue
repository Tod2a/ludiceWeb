<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';

const page = usePage();
const user = page.props.auth.user;

const Layout = user ? AuthenticatedLayout : GuestLayout;
</script>

<template>

    <Head title="Confidentialité" />
    <component :is="Layout">
        <template #header>
            <h2 class="text-2xl font-semibold">
                Politique de Confidentialité
            </h2>
        </template>

        <div class="bg-white shadow-md rounded-lg p-8 mx-20">
            <p class="text-sm text-gray-500 mb-4"><strong>Dernière mise à jour :</strong> 22 mai 2025</p>

            <section class="mb-6">
                <h3 class="text-xl font-semibold mb-2">1. Introduction</h3>
                <p>
                    Bienvenue sur <strong>Ludice</strong>. Votre vie privée est importante pour nous.
                    Cette politique explique quelles données nous collectons, comment nous les utilisons,
                    et quels sont vos droits concernant ces données.
                </p>
            </section>

            <section class="mb-6">
                <h3 class="text-xl font-semibold mb-2">2. Données collectées</h3>
                <p>Ludice peut collecter les informations suivantes :</p>
                <ul class="list-disc list-inside ml-4 space-y-1">
                    <li>Identifiant utilisateur (lors de la création d’un compte)</li>
                    <li>Adresse e-mail (si vous en fournissez une)</li>
                    <li>Données de ludothèque (jeux ajoutés, scores, commentaires)</li>
                </ul>

                <p class="mt-4 font-semibold">Nous ne collectons pas :</p>
                <ul class="list-disc list-inside ml-4 space-y-1">
                    <li>Vos contacts</li>
                    <li>Votre localisation précise</li>
                    <li>Vos photos, fichiers ou données sensibles</li>
                </ul>
            </section>

            <section class="mb-6">
                <h3 class="text-xl font-semibold mb-2">3. Utilisation des données</h3>
                <p>Vos données sont utilisées pour :</p>
                <ul class="list-disc list-inside ml-4 space-y-1">
                    <li>Vous permettre de vous connecter à votre compte</li>
                    <li>Sauvegarder et synchroniser votre ludothèque</li>
                    <li>Améliorer les fonctionnalités de l’application</li>
                </ul>

                <p class="mt-2">
                    Nous <strong>ne vendons pas vos données</strong> et ne les partageons pas avec des tiers, sauf si la
                    loi l’exige.
                </p>
            </section>

            <section class="mb-6">
                <h3 class="text-xl font-semibold mb-2">4. Sécurité</h3>
                <p>
                    Nous mettons en place des mesures de sécurité pour protéger vos données
                    (authentification sécurisée, chiffrement côté serveur, etc.).
                </p>
            </section>

            <section class="mb-6">
                <h3 class="text-xl font-semibold mb-2">5. Stockage</h3>
                <p>
                    Les données sont stockées sur des serveurs sécurisés.
                </p>
            </section>

            <section class="mb-6">
                <h3 class="text-xl font-semibold mb-2">6. Vos droits</h3>
                <p>Vous pouvez à tout moment :</p>
                <ul class="list-disc list-inside ml-4 space-y-1">
                    <li>Demander la suppression de votre compte</li>
                    <li>Accéder aux données que nous avons sur vous</li>
                    <li>Corriger ou mettre à jour vos informations</li>
                </ul>
                <p class="mt-2">
                    Pour toute demande, contactez-nous à :
                    <a href="mailto:support@ludice.app" class="text-blue-600 underline">support@ludice.app</a>
                </p>
            </section>

            <section class="mb-6">
                <h3 class="text-xl font-semibold mb-2">7. Modifications</h3>
                <p>
                    Cette politique peut être mise à jour. Toute modification sera annoncée dans l’application ou sur
                    notre site.
                </p>
            </section>

            <section class="mb-6">
                <h3 class="text-xl font-semibold mb-2">8. Contact</h3>
                <p>
                    Pour toute question relative à cette politique de confidentialité, contactez-nous à :
                    <a href="mailto:support@ludice.app" class="text-blue-600 underline">support@ludice.app</a>
                </p>
            </section>
        </div>
    </component>
</template>
