<script setup>
defineProps({
    type: {
        type: String,
        default: 'button',
    },
});
</script>

<template>
    <button
        :type="type"
        disabled
        class="inline-flex items-center text-center rounded-md border border-gray-300 bg-gray-400 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-gray-500 shadow-sm transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-offset-2 opacity-50 cursor-not-allowed break-words"
    >
        <slot />
    </button>
</template>
