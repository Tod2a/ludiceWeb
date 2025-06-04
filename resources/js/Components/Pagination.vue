<script setup>
import { router } from '@inertiajs/vue3';

const props = defineProps({
    links: Array,
    currentPage: Number,
    lastPage: Number,
    prevPageUrl: String,
    nextPageUrl: String,
});

const changePage = (url) => {
    router.visit(url, {
        only: ['patchNotes'],
        preserveScroll: true,
        preserveState: true,
    });
};
</script>

<template>
    <div v-if="lastPage > 1" class="mt-4 text-left">
        <button v-if="prevPageUrl" @click="changePage(prevPageUrl)" class="text-sm mr-2">
            &lt; Previous
        </button>

        <span class="text-sm">
            Page {{ currentPage }} of {{ lastPage }}
        </span>

        <button v-if="nextPageUrl" @click="changePage(nextPageUrl)" class="text-sm ml-2">
            Next &gt;
        </button>
    </div>
</template>
