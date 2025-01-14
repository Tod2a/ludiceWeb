<script setup>

const props = defineProps({
    game: Object
})

</script>

<template>
    <div class="bg-white rounded-lg p-4 shadow-md hover:shadow-lg transition-shadow flex flex-col overflow-hidden">
        <div class="relative pb-2/3">
            <img
                :src="props.game.img_path"
                :alt="'Image ' + props.game.name"
            />
        </div>
        <div class="mt-2 flex flex-col">
            <h3 class="text-lg font-semibold truncate">{{ props.game.name }}</h3>
        </div>
    </div>
</template>
