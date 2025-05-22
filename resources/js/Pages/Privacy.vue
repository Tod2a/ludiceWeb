<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>

    <Head title="Confidentialité" />
    <GuestLayout>
        <template #header>
            <h2 class="text-2xl font-semibold">
                Politique de Confidentialité
            </h2>
        </template>

        <div class="bg-white shadow-md rounded-lg p-8">
            <p><strong>Dernière mise à jour : 22 mai 2025</strong></p>

            <h3>1. Introduction</h3>
            <p>
                Bienvenue sur <strong>Ludice</strong>. Votre vie privée est importante pour nous. Cette politique
                explique
                quelles données nous collectons, comment nous les utilisons, et quels sont vos droits concernant ces
                données.
            </p>

            <h3>2. Données collectées</h3>
            <p>Ludice peut collecter les informations suivantes :</p>
            <ul>
                <li>Identifiant utilisateur (lors de la création d’un compte)</li>
                <li>Adresse e-mail (si vous en fournissez une)</li>
                <li>Données de ludothèque (jeux ajoutés, scores, commentaires)</li>
                <li>Statistiques d'utilisation (de manière anonyme)</li>
            </ul>
            <p><strong>Nous ne collectons pas :</strong></p>
            <ul>
                <li>Vos contacts</li>
                <li>Votre localisation précise</li>
                <li>Vos photos, fichiers ou données sensibles</li>
            </ul>

            <h3>3. Utilisation des données</h3>
            <p>Vos données sont utilisées pour :</p>
            <ul>
                <li>Vous permettre de vous connecter à votre compte</li>
                <li>Sauvegarder et synchroniser votre ludothèque</li>
                <li>Améliorer les fonctionnalités de l’application</li>
            </ul>
            <p>
                Nous <strong>ne vendons pas vos données</strong>, et nous ne les partageons pas avec des tiers, sauf si
                la loi
                l’exige.
            </p>

            <h3>4. Sécurité</h3>
            <p>
                Nous mettons en place des mesures de sécurité pour protéger vos données (authentification sécurisée,
                chiffrement
                côté serveur, etc.).
            </p>

            <h3>5. Stockage</h3>
            <p>
                Les données sont stockées sur des serveurs sécurisés via notre infrastructure backend.
            </p>

            <h3>6. Vos droits</h3>
            <p>Vous pouvez à tout moment :</p>
            <ul>
                <li>Demander la suppression de votre compte</li>
                <li>Accéder aux données que nous avons sur vous</li>
                <li>Corriger ou mettre à jour vos informations</li>
            </ul>
            <p>
                Pour toute demande, contactez-nous à : <a href="mailto:support@ludice.app"
                    class="text-blue-600 underline">support@ludice.app</a>
            </p>

            <h3>7. Modifications</h3>
            <p>
                Cette politique peut être mise à jour. Toute modification sera annoncée dans l’application ou sur notre
                site.
            </p>

            <h3>8. Contact</h3>
            <p>
                Pour toute question relative à cette politique de confidentialité, contactez-nous à : <a
                    href="mailto:support@ludice.app" class="text-blue-600 underline">support@ludice.app</a>
            </p>
        </div>
    </GuestLayout>
</template>
