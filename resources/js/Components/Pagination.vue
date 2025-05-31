<script setup>
import { router } from '@inertiajs/vue3';

const props = defineProps({ links: Array });

const changePage = (url) => {
    router.visit(url, {
        only: ['patchNotes'],
        preserveScroll: true,
        preserveState: true,
    });
};
</script>

<template>
    <div v-if="links.length > 1" class="mt-4 flex justify-center space-x-2">
        <template v-for="(link, key) in links" :key="key">
            <span v-if="!link.url" class="px-4 py-2 bg-gray-200 rounded text-gray-500" v-html="link.label" />
            <button v-else @click="changePage(link.url)" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300"
                :class="{ 'bg-green-600 text-white': link.active }" v-html="link.label" />
        </template>
    </div>
</template>
