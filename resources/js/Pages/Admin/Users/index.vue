<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import { FwbModal } from 'flowbite-vue';
import { onMounted, ref } from 'vue';
import { TrashIcon, PencilIcon } from '@heroicons/vue/24/outline';
import NavLink from '@/Components/NavLink.vue';
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

const confirmingUserDeletion = ref(false);

const confirmUserDeletion = ($id, $name) => {
    form.id = $id;
    form.name = $name;
    confirmingUserDeletion.value = true;
};

const deleteUser = () => {
    form.delete(route('users.destroy', form.id), {
        onSuccess: () => closeModal(),
    });
};

const closeModal = () => {
    confirmingUserDeletion.value = false;
    form.reset();
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

        <div class="flex justify-center">
            <div class="my-3">
                <NavLink :href="route('users.create')" class="bg-gray-300 px-2 py-2 rounded-lg hover:bg-gray-400">Nouvel
                    utilisateur</NavLink>
            </div>
        </div>

        <div class="bg-white shadow-md rounded-lg p-8">
            <div class="flex justify-center py-1">
                <input type="text" v-model="searchQuery" @input="debouncedSearch" placeholder="Search by email" />
            </div>

            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-left rtl:text-right text-gray-500 dark:text-gray-400">
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
                            class="hover:bg-gray-50 odd:bg-gray-100 hover:odd:bg-gray-200 transition">
                            <td class="border px-4 py-2"> {{ user.name }}</td>
                            <td class="border px-4 py-2"> {{ user.email }}</td>
                            <td class="border px-4 py-2">{{ formattedEmailVerifiedAt(user) }}</td>
                            <td class="border px-4 py-2">{{ user.role.name }}</td>
                            <td class="border px-4 py-2">{{ formattedCreatedAt(user) }}</td>
                            <td class="border px-4 py-2 space-x-4">
                                <div class="flex space-x-4">
                                    <Link :href="route('users.edit', user.id)">
                                    <PencilIcon class="w-5 h-5 text-blue-500" />
                                    </Link>
                                    <Button @click="confirmUserDeletion(user.id, user.name)">
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
                                    &gt;</button>>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <fwb-modal v-if="confirmingUserDeletion" @close="closeModal">
                <template #header>
                    <h2 class="text-lg font-medium text-gray-900">
                        Are you sure you want to delete this user?
                    </h2>
                </template>
                <template #body>
                    <p class="text-sm text-gray-500">
                        This action cannot be undone.
                    </p>
                </template>
                <template #footer>
                    <button @click="closeModal"
                        class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5">
                        Cancel
                    </button>
                    <button @click="deleteUser"
                        class="text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5">
                        Delete
                    </button>
                </template>
            </fwb-modal>
        </div>
    </AuthenticatedLayout>
</template>
