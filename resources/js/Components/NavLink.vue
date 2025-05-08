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
    'inline-flex items-center rounded-md border border-transparent bg-green-800 px-4 py-2 text-xs font-semibold uppercase tracking-widest transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-green-700 focus:ring-offset-2 hover:bg-green-700 active:bg-green-900 ' +
    (props.active ? 'text-yellow-300' : 'text-white')
);

</script>

<template>
    <Link :href="href" :class="classes">
    <slot />
    </Link>
</template>
