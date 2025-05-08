<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import NavLink from '@/Components/NavLink.vue';
import Multiselect from '@vueform/multiselect'
import '@vueform/multiselect/themes/default.css'
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { ref } from 'vue';

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
            </div>
        </div>

        <div class="flex justify-center">
            <div class="bg-white shadow-md rounded-lg p-8 w-1/2">
                <form @submit.prevent="form.post(route('games.store'), { forceFormData: true })" class="flex flex-col">
                    <div>
                        <label for="name">Nom <span class="text-red-500">*</span> : </label>
                        <input class="block mt-1 w-full" id="name" type="text" v-model="form.name">
                        <div v-if="form.errors.name">{{ form.errors.name }}</div>
                    </div>

                    <div>
                        <label for="published_at">Date de publication :</label>
                        <div class="relative mt-1">
                            <input id="published_at" type="date" v-model="form.published_at"
                                class="block w-full border border-gray-300 rounded-lg p-2.5 text-sm focus:ring-blue-500 focus:border-blue-500" />
                        </div>
                        <div v-if="form.errors.published_at" class="text-red-500 text-sm">{{ form.errors.published_at }}
                        </div>
                    </div>

                    <div>
                        <label for="min_players">Joueurs minimum <span class="text-red-500">*</span> : </label>
                        <input class="block mt-1 w-full" id="min_players" type="number" v-model="form.min_players"
                            step="1" max="150">
                        <div v-if="form.errors.min_players">{{ form.errors.min_players }}</div>
                    </div>

                    <div>
                        <label for="max_players">Joueurs maximum <span class="text-red-500">*</span> : </label>
                        <input class="block mt-1 w-full" id="max_players" type="number" v-model="form.max_players"
                            step="1" max="150">
                        <div v-if="form.errors.max_players">{{ form.errors.max_players }}</div>
                    </div>

                    <div>
                        <label for="average_duration">Durée moyenne <span class="text-red-500">*</span> : </label>
                        <input class="block mt-1 w-full" id="average_duration" type="number"
                            v-model="form.average_duration" step="1" max="150">
                        <div v-if="form.errors.average_duration">{{ form.errors.average_duration }}</div>
                    </div>

                    <div>
                        <label for="EAN">EAN <span class="text-red-500">*</span> : </label>
                        <input class="block mt-1 w-full" id="EAN" type="number" v-model="form.EAN" step="1" max="150">
                        <div v-if="form.errors.EAN">{{ form.errors.EAN }}</div>
                    </div>

                    <div>
                        <label for="suggestedage">Âge suggéré <span class="text-red-500">*</span> : </label>
                        <input class="block mt-1 w-full" id="suggestedage" type="number" v-model="form.suggestedage"
                            step="1" max="150">
                        <div v-if="form.errors.suggestedage">{{ form.errors.suggestedage }}</div>
                    </div>

                    <div>
                        <label for="publishers">Éditeurs <span class="text-red-500">*</span> : </label>
                        <Multiselect v-model="form.publishers" id="publishers"
                            :options="props.publishers.map(p => ({ value: p.id, label: p.name }))" mode="multiple"
                            label="label" valueProp="value" placeholder="Sélectionner un ou plusieurs éditeurs" />
                        <div v-if="form.errors.publishers">{{ form.errors.publishers }}</div>
                    </div>

                    <div>
                        <label for="creators">Créateurs <span class="text-red-500">*</span> : </label>
                        <Multiselect v-model="form.creators" id="creators" :options="props.creators.map(c => ({
                            value: c.id,
                            label: `${c.firstname} ${c.lastname}`
                        }))" mode="multiple" label="label" valueProp="value"
                            placeholder="Sélectionner un ou plusieurs créateurs" />
                        <div v-if="form.errors.creators">{{ form.errors.creators }}</div>
                    </div>

                    <div>
                        <label for="categories">Catégories <span class="text-red-500">*</span> : </label>
                        <Multiselect v-model="form.categories" id="categories"
                            :options="props.categories.map(c => ({ value: c.id, label: c.name }))" mode="multiple"
                            label="label" valueProp="value" placeholder="Sélectionner une ou plusieurs catégories" />
                        <div v-if="form.errors.categories">{{ form.errors.categories }}</div>
                    </div>

                    <div>
                        <label for="mechanics">Mécaniques <span class="text-red-500">*</span> : </label>
                        <Multiselect v-model="form.mechanics" id="mechanics"
                            :options="props.mechanics.map(m => ({ value: m.id, label: m.name }))" mode="multiple"
                            label="label" valueProp="value" placeholder="Sélectionner une ou plusieurs mécaniques" />
                        <div v-if="form.errors.mechanics">{{ form.errors.mechanics }}</div>
                    </div>

                    <div>
                        <label for="description">Description <span class="text-red-500">*</span> : </label>
                        <textarea class="block mt-1 w-full" id="description" v-model="form.description" />
                        <div v-if="form.errors.description">{{ form.errors.description }}</div>
                    </div>

                    <div class="flex justify-between">
                        <div class="flex flex-col">
                            <label for="imgurl">Image de couverture <span class="text-red-500">*</span> :</label>
                            <input id="imgurl" type="file" @input="form.imgurl = $event.target.files[0]">
                            <div v-if="form.errors.imgurl">{{ form.errors.imgurl }}</div>
                        </div>

                        <div class="mt-4 flex items-center">
                            <input id="is_expansion" type="checkbox" v-model="form.is_expansion"
                                class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500" />
                            <label for="is_expansion" class="ml-2 text-sm text-gray-700">
                                Ce jeu est une extension ?
                            </label>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
