<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';
import SecondaryButton from './SecondaryButton.vue';
import PrimaryButton from './PrimaryButton.vue';

const props = defineProps({
    show: Boolean,
    title: String,
    itemType: String,
    routeName: String,
});

const emits = defineEmits(['close']);

const name = ref('');
const error = ref(null);
const loading = ref(false);

const close = () => {
    name.value = '';
    error.value = null;
    emits('close');
};

const submit = () => {
    if (!name.value.trim()) {
        error.value = `Le nom de la ${props.itemType} est requis.`;
        return;
    }

    loading.value = true;
    router.post(route(props.routeName), { name: name.value }, {
        onSuccess: () => {
            close();
        },
        onError: (errors) => {
            error.value = errors.name || 'Erreur inconnue.';
        },
        onFinish: () => {
            loading.value = false;
        }
    });
};
</script>

<template>
    <div v-if="show" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white rounded-lg shadow-lg p-6 w-96">
            <h2 class="text-lg font-semibold mb-4">{{ title }}</h2>

            <input type="text" v-model="name" class="w-full border border-gray-300 rounded px-3 py-2 mb-4"
                :placeholder="`Nom de la ${itemType}`" />

            <div v-if="error" class="text-red-500 text-sm mb-2">{{ error }}</div>

            <div class="flex justify-end gap-2">
                <SecondaryButton @click="close" class="px-4 py-2 text-gray-600 hover:text-black">Fermer
                </SecondaryButton>
                <PrimaryButton @click.prevent="submit"
                    class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700" :disabled="loading">
                    {{ loading ? 'Envoi...' : 'Sauvegarder' }}
                </PrimaryButton>
            </div>
        </div>
    </div>
</template>
