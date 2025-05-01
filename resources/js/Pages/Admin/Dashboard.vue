<script setup>
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
</script>

<template>
    <Head title="Admin Dashboard" />

    <AuthenticatedLayout>
        <p>Welcome to your dashboard</p>
    </AuthenticatedLayout>
</template>
