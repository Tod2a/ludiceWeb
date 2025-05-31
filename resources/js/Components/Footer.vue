<template>
    <footer class="bg-primary text-center text-sm text-gray-400 py-4 border-t">
        <p>© 2025 Ludice. Tous droits réservés.</p>
        <p>Version – 1.1.0</p>
        <p>
            Contact : <a href="mailto:support@ludice.app" class="text-blue-500 hover:underline">support@ludice.app</a>
        </p>
        <p class="mt-1">
            <!-- <a href="/legal-notice" class="hover:underline">Mentions légales</a> | -->
            <a :href="route('privacy')" class="hover:underline">Politique de confidentialité</a>
        </p>
    </footer>
</template>
