<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import SecondaryButton from './SecondaryButton.vue';
import PrimaryButton from './PrimaryButton.vue';

const props = defineProps({
    show: Boolean,
});

const loading = ref(false);

const emits = defineEmits(['close']);

const form = useForm({
    firstname: null,
    lastname: null,
})

const close = () => {
    form.reset();
    emits('close');
}

const submit = () => {
    loading.value = true;
    form.post(route('creator.store'), {
        onSuccess: () => {
            close();
        },
        onFinish: () => {
            loading.value = false;
        }
    });
}
</script>

<template>
    <div v-if="show" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white rounded-lg shadow-lg p-6 w-96">
            <h2 class="text-lg font-semibold mb-4">Création d'un nouveau créateur</h2>

            <input type="text" v-model="form.firstname" class="w-full border border-gray-300 rounded px-3 py-2 mb-4"
                placeholder="Prénom" />

            <input type="text" v-model="form.lastname" class="w-full border border-gray-300 rounded px-3 py-2 mb-4"
                placeholder="Nom" />

            <div v-if="form.errors.firstname" class="text-red-500 text-sm mb-2">{{ form.errors.firstname }}</div>
            <div v-if="form.errors.lastname" class="text-red-500 text-sm mb-2">{{ form.errors.lastname }}</div>

            <div class="flex justify-end gap-2">
                <SecondaryButton @click="close" class="px-4 py-2 text-gray-600 hover:text-black">Fermer
                </SecondaryButton>
                <PrimaryButton @click.prevent="submit" :disabled="loading">
                    {{ loading ? 'Envoi...' : 'Sauvegarder' }}
                </PrimaryButton>
            </div>
        </div>
    </div>
</template>
