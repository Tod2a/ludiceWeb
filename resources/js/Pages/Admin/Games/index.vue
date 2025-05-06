<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import { FwbModal } from 'flowbite-vue';
import { onMounted, ref } from 'vue';
import { TrashIcon, PencilIcon } from '@heroicons/vue/24/outline';
import NavLink from '@/Components/NavLink.vue';
import { initFlowbite } from 'flowbite';
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
            <p>Hello</p>
        </div>
    </AuthenticatedLayout>

</template>
