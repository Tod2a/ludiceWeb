<script setup>
const props = defineProps({
    show: Boolean,
})

const emits = defineEmits(['close'])
</script>

<template>
    <teleport to="body">
        <div v-if="show" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white rounded-lg shadow-lg p-6 w-[500px]">

                <div class="mb-4 flex justify-between items-center">
                    <slot name="title">
                        <h2 class="text-lg font-semibold text-gray-900">Titre du modal</h2>
                    </slot>
                    <button @click="$emit('close')" class="text-gray-400 hover:text-black focus:outline-none">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="mb-6">
                    <slot name="body">
                        Contenu du modal...
                    </slot>
                </div>

                <div class="flex justify-end gap-2">
                    <slot name="footer" />
                </div>
            </div>
        </div>
    </teleport>
</template>
