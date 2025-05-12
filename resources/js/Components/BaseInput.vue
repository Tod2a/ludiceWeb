<script setup>
defineProps({
    id: { type: String, required: true },
    modelValue: { type: [String, Number, null], required: true },
    type: { type: String, default: 'text' },
    placeholder: { type: String, default: '' },
    error: { type: String, default: '' },
    required: { type: Boolean, default: false },
});
</script>

<template>
    <div class="mb-4">
        <label :for="id" class="block text-sm font-medium text-gray-700">
            <slot></slot> <span v-if="required" class="text-red-500">*</span>
        </label>
        <input v-bind="$attrs" :id="id" :type="type" :value="modelValue" :placeholder="placeholder"
            @input="$emit('update:modelValue', $event.target.value)"
            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
        <p v-if="error" class="mt-1 text-sm text-red-600">{{ error }}</p>
    </div>
</template>
