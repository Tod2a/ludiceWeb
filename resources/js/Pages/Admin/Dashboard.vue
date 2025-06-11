<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ref } from 'vue';
import Pagination from '@/Components/Pagination.vue';
import Modal from '@/Components/Modal.vue';

const props = defineProps({
    appStartWeek: Number,
    appStartMonth: Number,
    selectedGameWeek: Number,
    selectedGameMonth: Number,
    totalGames: Number,
    verifiedUsers: Number,
    patchNotes: Object,
})

const form = useForm({
    title: null,
    description: null
})

const isPatchModalVisible = ref(false);

const postPatchNote = () => {
    form.post(route('admin.patchnotes.store'), {
        onSuccess: () => closePatchModal(),
    });
};

const closePatchModal = () => {
    isPatchModalVisible.value = false;
    form.reset();
    debouncedSearch();
};

</script>

<template>

    <Head title="Admin Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-2xl font-semibold">
                Tableau de bord
            </h2>
        </template>

        <div class="space-y-8 mx-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                <div class="bg-white shadow rounded-lg p-6 flex flex-col justify-center items-center">
                    <h3 class="text-lg font-medium text-gray-700 mb-2">Nombre total d'inscrits</h3>
                    <p class="text-3xl font-bold text-green-600">{{ verifiedUsers }}</p>
                </div>

                <div class="bg-white shadow rounded-lg p-6 flex flex-col justify-center items-center">
                    <h3 class="text-lg font-medium text-gray-700 mb-2">Nombre total de jeux</h3>
                    <p class="text-3xl font-bold text-green-600">{{ totalGames }}</p>
                </div>

                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-700 mb-2">Les Ludistes ont ouvert notre application
                    </h3>
                    <p class="text-green-600 font-semibold text-xl">
                        {{ appStartWeek }} fois cette semaine
                    </p>
                    <p class="text-green-600 font-semibold text-xl">
                        {{ appStartMonth }} fois ce mois-ci
                    </p>
                </div>

                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-700 mb-2">Nous avons aidé à choisir le jeu de la soirée
                    </h3>
                    <p class="text-green-600 font-semibold text-xl">
                        {{ selectedGameWeek }} fois cette semaine
                    </p>
                    <p class="text-green-600 font-semibold text-xl">
                        {{ selectedGameMonth }} fois ce mois-ci
                    </p>
                </div>
            </div>

            <div class="bg-green-50 border border-green-300 rounded-lg p-6 text-center">
                <p class="text-green-900 text-lg font-medium">
                    Merci pour votre travail et votre implication dans le projet, nous construisons ensemble le
                    compagnon parfait de nos soirées ludiques.
                </p>
            </div>

        </div>

        <div class="bg-gray-100 p-4 mt-4 rounded shadow mx-8">

            <div class="flex flex-row justify-between">
                <h3 class="text-3xl">Actualités & mises à jour</h3>

                <button v-if="$page.props.auth.user.role.name === 'Master'" @click="isPatchModalVisible = true"
                    class="text-white bg-green-700 hover:bg-green-600 rounded-full w-8 h-8 flex items-center justify-center text-2xl font-bold focus:outline-none focus:ring-2 focus:ring-green-500"
                    aria-label="Ajouter une note de patch">
                    +
                </button>
            </div>

            <div v-for="note in patchNotes.data" :key="note.id" class="mt-4 bg-white p-4 rounded shadow">
                <h4 class="text-lg font-semibold">{{ note.title }}</h4>
                <p class="text-gray-700">{{ note.description }}</p>
                <p class="text-sm text-gray-400">
                    Publié par {{ note.user?.name ?? 'Inconnu' }} le {{ new Date(note.created_at).toLocaleDateString()
                    }}
                </p>
            </div>

            <Pagination :links="patchNotes.links" :currentPage="patchNotes.current_page"
                :lastPage="patchNotes.last_page" :prevPageUrl="patchNotes.prev_page_url"
                :nextPageUrl="patchNotes.next_page_url" />

        </div>

    </AuthenticatedLayout>

    <Modal :show="isPatchModalVisible" @close="closePatchModal">
        <template #title>
            <h2 class="text-lg font-medium text-gray-900">Ajoutez une nouvelle note.</h2>
        </template>

        <template #body>
            <div class="mb-4">
                <label for="title" class="block text-sm font-medium text-gray-700">Titre</label>
                <input id="title" type="text" v-model="form.title" required maxlength="255"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-300 focus:ring-opacity-50" />
            </div>
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea id="description" v-model="form.description" required rows="4"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-300 focus:ring-opacity-50"></textarea>
            </div>
        </template>

        <template #footer>
            <button @click="closePatchModal"
                class="text-gray-600 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-300 text-sm font-medium px-5 py-2.5">
                Annuler
            </button>
            <button @click="postPatchNote"
                class="text-white bg-green-800 hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5">
                Ajouter
            </button>
        </template>
    </Modal>
</template>
