<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import NavLink from '@/Components/NavLink.vue';
import '@vueform/multiselect/themes/default.css'
import PrimaryButton from '@/Components/PrimaryButton.vue';
import BaseInput from '@/Components/BaseInput.vue';
import { ref } from 'vue';
import { PublisherAutocomplete, MechanicAutocomplete, CreatorAutocomplete, CategoryAutocomplete } from '@/Components/Autocompletes';
import BaseCreatingModal from '@/Components/BaseCreatingModal.vue';
import NewCreatorModal from '@/Components/NewCreatorModal.vue';

const props = defineProps({
    game: Object,
})

const imgInput = ref(null);
const NewMechanicModal = ref(false);
const NewPublisherModal = ref(false);
const NewCategoryModal = ref(false);
const NewCreatorModalVisible = ref(false);

const gameId = props.game.id;

const form = useForm({
    _method: 'put',
    name: props.game.name,
    description: props.game.description,
    published_at: props.game.published_at,
    imgurl: null,
    min_players: props.game.min_players,
    max_players: props.game.max_players,
    average_duration: props.game.average_duration,
    EAN: props.game.EAN,
    suggestedage: props.game.suggestedage,
    is_expansion: props.game.is_expansion,
    publishers: props.game.publishers,
    creators: props.game.creators,
    mechanics: props.game.mechanics,
    categories: props.game.categories,
});

const submitForm = () => {
    form.post(route('games.update', gameId), {
        forceFormData: true,
        onSuccess: () => {
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

const addMechanic = (mechanic) => {
    if (!form.mechanics.some(m => m.id === mechanic.id)) {
        form.mechanics.push(mechanic);
    }
};

const addCreator = (creator) => {
    if (!form.creators.some(c => c.id === creator.id)) {
        form.creators.push(creator);
    }
}

const addCategory = (category) => {
    if (!form.categories.some(c => c.id === category.id)) {
        form.categories.push(category);
    }
}

const removePublisher = (id) => {
    form.publishers = form.publishers.filter(p => p.id !== id);
};

const removeMechanic = (id) => {
    form.mechanics = form.mechanics.filter(m => m.id !== id);
};

const removeCreator = (id) => {
    form.creators = form.creators.filter(c => c.id !== id);
}

const removeCategory = (id) => {
    form.categories = form.categories.filter(c => c.id !== id);
}

</script>

<template>

    <Head title="Admin" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-2xl font-semibold">
                Édition du jeu: {{ form.name }}
            </h2>
        </template>

        <div class="flex justify-center">
            <div class="my-3">
                <NavLink :href="route('games.index')">Retour</NavLink>
                <Transition enter-active-class="transition ease-in-out" enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out" leave-to-class="opacity-0">
                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Modifié avec succès.</p>
                </Transition>
            </div>
        </div>

        <div class="flex justify-center">
            <div class="bg-white shadow-md rounded-lg p-8 w-1/2 max-w-full">
                <form @submit.prevent="submitForm" class="flex flex-col">
                    <BaseInput id="name" v-model="form.name" placeholder="Enter the game name" :error="form.errors.name"
                        :required="true">Nom</BaseInput>

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
                        <label for="publishers">Éditeurs <span class="text-red-500">*</span>
                            <button @click.prevent="NewPublisherModal = true" class="mx-2 text-blue-500">
                                Créer un nouvel éditeur
                            </button></label>
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

                    <BaseCreatingModal :show="NewPublisherModal" title="Créer un éditeur" placeholder="nom de l'éditeur"
                        routeName="publisher.store" @close="NewPublisherModal = false" />

                    <div class="mb-4">
                        <label for="creators">Créateurs <span class="text-red-500">*</span>
                            <button @click.prevent="NewCreatorModalVisible = true" class="mx-2 text-blue-500">
                                Créer un nouveau créateur
                            </button></label>
                        <CreatorAutocomplete @add-creator="addCreator" />
                        <div v-if="form.errors.creators" class="text-red-500 text-sm">{{ form.errors.creators }}</div>
                    </div>

                    <div v-if="form.creators.length > 0" class="mb-4">
                        <label>Créateurs sélectionnés:</label>
                        <ul class="list-disc list-inside">
                            <li v-for="creator in form.creators" :key="creator.id"
                                class="flex items-center justify-between">
                                <span>{{ creator.firstname }} {{ creator.lastname }}</span>
                                <button @click="removeCreator(creator.id)" class="text-red-500 hover:text-red-700 ml-2"
                                    aria-label="Supprimer le créateur">
                                    &times;
                                </button>
                            </li>
                        </ul>
                    </div>

                    <NewCreatorModal :show="NewCreatorModalVisible" @close="NewCreatorModalVisible = false" />

                    <div class="mb-4">
                        <label for="categories">Catégories <span class="text-red-500">*</span>
                            <button @click.prevent="NewCategoryModal = true" class="mx-2 text-blue-500">
                                Créer une nouvelle catégorie
                            </button></label>
                        <CategoryAutocomplete @add-category="addCategory" />
                        <div v-if="form.errors.categories" class="text-red-500 text-sm">{{ form.errors.categories }}
                        </div>
                    </div>

                    <div v-if="form.categories.length > 0" class="mb-4">
                        <label>Categories sélectionnées:</label>
                        <ul class="list-disc list-inside">
                            <li v-for="category in form.categories" :key="category.id"
                                class="flex items-center justify-between">
                                {{ category.name }}
                                <button @click="removeCategory(category.id)"
                                    class="text-red-500 hover:text-red-700 ml-2" aria-label="Supprimer la catégorie">
                                    &times;
                                </button>
                            </li>
                        </ul>
                    </div>

                    <BaseCreatingModal :show="NewCategoryModal" title="Créer une catégorie"
                        placeholder="nom de la catégorie" routeName="category.store"
                        @close="NewCategoryModal = false" />

                    <div class="mb-4">
                        <label for="mechanics">Mécaniques <span class="text-red-500">*</span>
                            <button @click.prevent="NewMechanicModal = true" class="mx-2 text-blue-500">
                                Créer une nouvelle mécanique
                            </button></label>
                        <MechanicAutocomplete @add-mechanic="addMechanic" />
                        <div v-if="form.errors.mechanics" class="text-red-500 text-sm">{{ form.errors.mechanics }}
                        </div>
                    </div>

                    <div v-if="form.mechanics.length > 0" class="mb-4">
                        <label>Mécaniques sélectionnées:</label>
                        <ul class="list-disc list-inside">
                            <li v-for="mechanic in form.mechanics" :key="mechanic.id"
                                class="flex items-center justify-between">
                                {{ mechanic.name }}
                                <button @click="removeMechanic(mechanic.id)"
                                    class="text-red-500 hover:text-red-700 ml-2" aria-label="Supprimer la mécanique">
                                    &times;
                                </button>
                            </li>
                        </ul>
                    </div>

                    <BaseCreatingModal :show="NewMechanicModal" title="Créer une mécanique"
                        placeholder="nom de la mécanique" routeName="mechanic.store"
                        @close="NewMechanicModal = false" />

                    <div class="mb-4">
                        <label for="description">Description <span class="text-red-500">*</span> </label>
                        <textarea
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            id="description" v-model="form.description" />
                        <div v-if="form.errors.description" class="text-red-500 text-sm">{{ form.errors.description }}
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="img">Image actuelle</label>
                        <img id="img" :src="props.game.img_path" :alt="`Image ${props.game.name}`"
                            class="max-w-full max-h-64 object-contain mt-2" />
                    </div>

                    <div class="flex justify-between mb-4">
                        <div class="flex flex-col">
                            <label for="imgurl">Changer l'image <span class="text-red-500">*</span></label>
                            <input id="imgurl" type="file" @input="form.imgurl = $event.target.files[0]" ref="imgInput">
                            <div v-if="form.errors.imgurl" class="text-red-500 text-sm">{{ form.errors.imgurl }}</div>
                        </div>

                        <div class="mt-4 flex items-center">
                            <input id="is_expansion" type="checkbox" v-model="form.is_expansion"
                                class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500" />
                            <label for="is_expansion" class="ml-2 text-sm text-gray-700">
                                Is this an expansion?
                            </label>
                        </div>
                    </div>

                    <div class="flex items-center gap-4 mt-1">
                        <PrimaryButton :disabled="form.processing">Update</PrimaryButton>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
