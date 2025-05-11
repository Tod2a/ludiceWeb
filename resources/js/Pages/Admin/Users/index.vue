<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import { FwbModal } from 'flowbite-vue';
import { onMounted, ref } from 'vue';
import { TrashIcon, PencilIcon } from '@heroicons/vue/24/outline';
import { initFlowbite } from 'flowbite';

const props = defineProps({
    roles: Array,
})

const searchQuery = ref('');
const users = ref([]);

const fetchUsers = async (url) => {
    const response = await axios.get(url, {
        params: {
            query: searchQuery.value
        },
    });
    users.value = response.data;
};

const debouncedSearch = (() => {
    let timerId;
    return () => {
        clearTimeout(timerId);

        timerId = setTimeout(() => {
            fetchUsers(route('users.search'));
        }, 300);
    };
})();

onMounted(() => {
    debouncedSearch();
    initFlowbite()
})

const form = useForm({
    id: null,
    name: null
})

const editForm = useForm({
    id: null,
    name: null,
    role_id: null
})

const isDeleteModalVisible = ref(false);
const isEditModalVisible = ref(false);

const openEditModal = (id, name, roleId) => {
    editForm.id = id;
    editForm.name = name;
    editForm.role_id = roleId;
    isEditModalVisible.value = true;
};

const updateUserRole = () => {
    editForm.patch(route('users.update', editForm.id), {
        data: { role_id: editForm.role_id },
        onSuccess: () => {
            closeEditModal();
            debouncedSearch();
        },
    });
};

const confirmUserDeletion = (id, name) => {
    form.id = id;
    form.name = name;
    isDeleteModalVisible.value = true;
};

const deleteUser = () => {
    form.delete(route('users.destroy', form.id), {
        onSuccess: () => closeModal(),
    });
};

const closeModal = () => {
    isDeleteModalVisible.value = false;
    form.reset();
    debouncedSearch();
};

const closeEditModal = () => {
    isEditModalVisible.value = false;
    editForm.reset();
    debouncedSearch();
};

const formattedEmailVerifiedAt = (user) => {
    return user.email_verified_at ? new Date(user.email_verified_at).toLocaleDateString('fr-FR', { year: 'numeric', month: 'long', day: 'numeric' }) : '-';
};

const formattedCreatedAt = (user) => {
    return new Date(user.created_at).toLocaleString('fr-FR');
};

</script>

<template>

    <Head title="Admin" />

    <AuthenticatedLayout>

        <template #header>
            <h2 class="text-2xl font-semibold">
                Gestion utilisateurs
            </h2>
        </template>

        <div class="bg-white shadow-md rounded-lg p-8">
            <div class="flex justify-center py-1">
                <input type="text" v-model="searchQuery" @input="debouncedSearch" placeholder="Search by email" />
            </div>

            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-left rtl:text-right text-gray-500 dark:text-primary">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr class="uppercase text-left">
                            <th class="px-4 py-2 border">nom</th>
                            <th class="px-4 py-2 border">email</th>
                            <th class="px-4 py-2 border">date vérification</th>
                            <th class="px-4 py-2 border">role</th>
                            <th class="px-4 py-2 border">date de création</th>
                            <th class="px-4 py-2 border">actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="user in users.data" :key="user.id"
                            class="odd:bg-white even:bg-gray-100 hover:bg-gray-200 transition">
                            <td class="border px-4 py-2"> {{ user.name }}</td>
                            <td class="border px-4 py-2"> {{ user.email }}</td>
                            <td class="border px-4 py-2">{{ formattedEmailVerifiedAt(user) }}</td>
                            <td class="border px-4 py-2">{{ user.role.name }}</td>
                            <td class="border px-4 py-2">{{ formattedCreatedAt(user) }}</td>
                            <td class="border px-4 py-2 space-x-4">
                                <div class="flex space-x-4">
                                    <Button @click="openEditModal(user.id, user.name, user.role.id)">
                                        <PencilIcon class="w-5 h-5 text-blue-500" />
                                    </Button>
                                    <Button :disabled="user.role.name === 'Master'"
                                        @click="confirmUserDeletion(user.id, user.name)">
                                        <TrashIcon class="w-5 h-5 text-red-400" />
                                    </Button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4" class="px-6">
                                <button @click="fetchUsers(users.prev_page_url)" v-if="users.prev_page_url">&lt;
                                    Previous</button>
                                Page {{ users.current_page }} of {{ users.last_page }}
                                <button @click="fetchUsers(users.next_page_url)" v-if="users.next_page_url">Next
                                    &gt;</button>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <fwb-modal size="md" position="top-center" v-if="isDeleteModalVisible" @close="closeModal">
                <template #header>
                    <h2 class="text-lg font-medium text-gray-900">
                        Êtes-vous sûr de vouloir supprimer l'utilisateur {{ form.name }} ?
                    </h2>
                </template>
                <template #body>
                    <p class="text-sm text-gray-500">
                        Cette action est irréversible.
                    </p>
                </template>
                <template #footer>
                    <button @click="closeModal"
                        class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5">
                        Annuler
                    </button>
                    <button @click="deleteUser"
                        class="text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5">
                        Supprimer
                    </button>
                </template>
            </fwb-modal>

            <fwb-modal size="md" position="top-center" v-if="isEditModalVisible" @close="closeEditModal">
                <template #header>
                    <h2 class="text-lg font-medium text-gray-900">
                        Modifier le rôle de l'utilisateur {{ editForm.name }}
                    </h2>
                </template>
                <template #body>
                    <p class="text-sm text-gray-500">
                        Sélectionnez un nouveau rôle pour {{ editForm.name }} :
                    </p>
                    <select v-model="editForm.role_id" class="mt-2 w-full p-2 border rounded-md">
                        <option v-for="role in roles" :key="role.id" :value="role.id">
                            {{ role.name }}
                        </option>
                    </select>
                </template>
                <template #footer>
                    <button @click="closeEditModal"
                        class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5">
                        Annuler
                    </button>
                    <button @click="updateUserRole"
                        class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">
                        Mettre à jour
                    </button>
                </template>
            </fwb-modal>

        </div>
    </AuthenticatedLayout>
</template>
