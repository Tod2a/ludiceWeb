<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import NavLink from '@/Components/NavLink.vue';
import Multiselect from '@vueform/multiselect'
import '@vueform/multiselect/themes/default.css'
import PrimaryButton from '@/Components/PrimaryButton.vue';
import BaseInput from '@/Components/BaseInput.vue';
import { ref } from 'vue';
import PublisherAutocomplete from '@/Components/Autocompletes/PublisherAutocomplete.vue';

const imgInput = ref(null);

const props = defineProps({
    publishers: Array,
    creators: Array,
    mechanics: Array,
    categories: Array,
})

const form = useForm({
    name: null,
    description: null,
    published_at: null,
    imgurl: null,
    min_players: null,
    max_players: null,
    average_duration: null,
    EAN: null,
    suggestedage: null,
    is_expansion: false,
    publishers: [],
    creators: [],
    mechanics: [],
    categories: [],
})

const submitForm = () => {
    form.post(route('games.store'), {
        forceFormData: true,
        onSuccess: () => {
            form.reset();
            if (imgInput.value) {
                imgInput.value.value = null;
            }
        },
    });
};

const addPublisher = (publisher) => {
    if (!form.publishers.some(p => p.id === publisher.id)) {
        form.publishers.push(publisher);
    }
};

const removePublisher = (id) => {
    form.publishers = form.publishers.filter(p => p.id !== id);
};

</script>

<template>

    <Head title="Admin" />

    <AuthenticatedLayout>
        <template #header>

            <h2 class="text-2xl font-semibold">
                Creation d'un nouveau jeu
            </h2>
        </template>
        <div class="flex justify-center">
            <div class="my-3">
                <NavLink :href="route('games.index')">Back
                </NavLink>
                <Transition enter-active-class="transition ease-in-out" enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out" leave-to-class="opacity-0">

                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Saved.</p>
                </Transition>
            </div>
        </div>

        <div class="flex justify-center">
            <div class="bg-white shadow-md rounded-lg p-8 w-1/2">
                <form @submit.prevent="submitForm" class="flex flex-col">

                    <BaseInput id="name" v-model="form.name" placeholder="Entrez le nom du jeu"
                        :error="form.errors.name" :required="true">Nom
                    </BaseInput>

                    <div class="mb-4">
                        <label for="published_at">Date de publication <span class="text-red-500">*</span></label>
                        <div class="relative mt-1">
                            <input id="published_at" type="date" v-model="form.published_at"
                                class="block w-full border border-gray-300 rounded-lg p-2.5 text-sm focus:ring-blue-500 focus:border-blue-500" />
                        </div>
                        <div v-if="form.errors.published_at" class="text-red-500 text-sm">{{ form.errors.published_at }}
                        </div>
                    </div>

                    <BaseInput id="min_players" v-model="form.min_players"
                        placeholder="Entrez le nombre de joueurs minimum" :error="form.errors.min_players" type="number"
                        :required="true">Joueurs
                        minimum</BaseInput>

                    <BaseInput id="max_players" v-model="form.max_players"
                        placeholder="Entrez le nombre de joueurs maximum" :error="form.errors.max_players" type="number"
                        :required="true">Joueurs
                        maximum</BaseInput>

                    <BaseInput id="average_duration" v-model="form.average_duration"
                        placeholder="Entrez la durée moyenne" :error="form.errors.average_duration" type="number"
                        :required="true">Durée
                        moyenne</BaseInput>

                    <BaseInput id="EAN" v-model="form.EAN" placeholder="Entrez le numéro EAN (code à barres)"
                        :error="form.errors.EAN" type="number">EAN</BaseInput>

                    <BaseInput id="suggestedage" v-model="form.suggestedage" placeholder="Entrez l'âge suggéré'"
                        :error="form.errors.suggestedage" type="number" :required="true">Âge suggéré</BaseInput>

                    <div class="mb-4">
                        <label for="publishers">Éditeurs <span class="text-red-500">*</span></label>
                        <PublisherAutocomplete @add-publisher="addPublisher" />
                        <div v-if="form.errors.publishers" class="text-red-500 text-sm">{{ form.errors.publishers }}
                        </div>
                    </div>

                    <div v-if="form.publishers.length > 0" class="mb-4">
                        <label>Éditeurs sélectionnés:</label>
                        <ul class="list-disc list-inside">
                            <li v-for="publisher in form.publishers" :key="publisher.id"
                                class="flex items-center justify-between">
                                {{ publisher.name }}
                                <button @click="removePublisher(publisher.id)"
                                    class="text-red-500 hover:text-red-700 ml-2" aria-label="Supprimer l'éditeur">
                                    &times;
                                </button>
                            </li>
                        </ul>
                    </div>

                    <div class="mb-4">
                        <label for="creators">Créateurs <span class="text-red-500">*</span> </label>
                        <Multiselect v-model="form.creators" id="creators" :options="props.creators.map(c => ({
                            value: c.id,
                            label: `${c.firstname} ${c.lastname}`
                        }))" mode="multiple" label="label" valueProp="value"
                            placeholder="Sélectionner un ou plusieurs créateurs" />
                        <div v-if="form.errors.creators" class="text-red-500 text-sm">{{ form.errors.creators }}</div>
                    </div>

                    <div class="mb-4">
                        <label for="categories">Catégories <span class="text-red-500">*</span> </label>
                        <Multiselect v-model="form.categories" id="categories"
                            :options="props.categories.map(c => ({ value: c.id, label: c.name }))" mode="multiple"
                            label="label" valueProp="value" placeholder="Sélectionner une ou plusieurs catégories" />
                        <div v-if="form.errors.categories" class="text-red-500 text-sm">{{ form.errors.categories }}
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="mechanics">Mécaniques <span class="text-red-500">*</span> </label>
                        <Multiselect v-model="form.mechanics" id="mechanics"
                            :options="props.mechanics.map(m => ({ value: m.id, label: m.name }))" mode="multiple"
                            label="label" valueProp="value" placeholder="Sélectionner une ou plusieurs mécaniques" />
                        <div v-if="form.errors.mechanics" class="text-red-500 text-sm">{{ form.errors.mechanics }}</div>
                    </div>

                    <div class="mb-4">
                        <label for="description">Description <span class="text-red-500">*</span> </label>
                        <textarea
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            id="description" v-model="form.description" />
                        <div v-if="form.errors.description" class="text-red-500 text-sm">{{ form.errors.description }}
                        </div>
                    </div>

                    <div class="flex justify-between mb-4">
                        <div class="flex flex-col">
                            <label for="imgurl">Image de couverture <span class="text-red-500">*</span></label>
                            <input id="imgurl" type="file" @input="form.imgurl = $event.target.files[0]" ref="imgInput">
                            <div v-if="form.errors.imgurl" class="text-red-500 text-sm">{{ form.errors.imgurl }}</div>
                        </div>

                        <div class="mt-4 flex items-center">
                            <input id="is_expansion" type="checkbox" v-model="form.is_expansion"
                                class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500" />
                            <label for="is_expansion" class="ml-2 text-sm text-gray-700">
                                Ce jeu est une extension ?
                            </label>
                        </div>
                    </div>

                    <div class="flex items-center gap-4 mt-1">
                        <PrimaryButton :disabled="form.processing">Save</PrimaryButton>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
