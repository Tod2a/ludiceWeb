<script setup>
import SecondaryButton from './SecondaryButton.vue'
import PrimaryButton from './PrimaryButton.vue'

const props = defineProps({
    show: Boolean,
})

const emits = defineEmits(['accept', 'refuse'])
</script>

<template>
    <div v-if="show" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white rounded-lg shadow-lg p-6 w-96">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">
                Mise à jour de la Politique de confidentialité
            </h2>

            <p class="text-sm text-gray-700 mb-6">
                Vous devez accepter la
                <a href="/privacy-policy" target="_blank"
                    class="text-green-600 hover:underline transition duration-150 ease-in-out">
                    politique de confidentialité
                </a> pour pouvoir continuer.
            </p>

            <div class="flex justify-end gap-2">
                <SecondaryButton @click="$emit('refuse')" class="bg-red-600 text-white hover:bg-red-700">
                    Refuser
                </SecondaryButton>
                <PrimaryButton @click="$emit('accept')">
                    Accepter
                </PrimaryButton>
            </div>
        </div>
    </div>
</template>
