<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { onMounted } from 'vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { ref } from 'vue';
import { TrashIcon, PencilIcon } from '@heroicons/vue/24/outline';

</script>

<template>

    <Head title="Admin" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-2xl font-semibold">
                Creation d'un nouveau jeu
            </h2>
        </template>

        <div class="bg-white shadow-md rounded-lg p-8">
            <p>Coming soon</p>
        </div>
    </AuthenticatedLayout>
</template>
