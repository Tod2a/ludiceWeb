<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    href: {
        type: String,
        required: true,
    },
    active: {
        type: Boolean,
    },
});

const classes = computed(() =>
    props.active
        ? 'inline-flex items-center rounded-md border border-transparent bg-green-200 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-secondary-dark transition duration-150 ease-in-out hover:bg-green-100 focus:bg-green-100 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 active:bg-green-400'
        : 'inline-flex items-center rounded-md border border-transparent bg-green-200 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-secondary transition duration-150 ease-in-out hover:bg-green-100 focus:bg-green-100 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 active:bg-green-300',
);
</script>

<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>
