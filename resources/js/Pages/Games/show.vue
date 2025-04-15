<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';

const props = defineProps({
    game: Object,
});

</script>

<template>
    <Head title="game detail" />

    <AuthenticatedLayout>

        <p>There will be the details page!</p>

    </AuthenticatedLayout>
</template>
