<script setup>
import ToastListItem from './ToastListItem.vue';
import { router } from '@inertiajs/vue3';
import {ref} from "vue";

const items = ref([]);

router.on('success', (event) => {
  const flash = event.detail.page.props.flash;
  if (flash.success) {
    items.value.unshift({
        key: Symbol(),
        message: flash.success,
        type: 'success'
    });
  }
  if (flash.error) {
    items.value.unshift({
        key: Symbol(),
        message: flash.error,
        type: 'error'
    });
  }
});

function remove(index){
    items.value.splice(index, 1);
}
</script>

<template>
    <TransitionGroup
        tag="div"
        enter-from-class="translate-x-full opacity-0"
        enter-active-class="duration-500"
        leave-active-class="duration-500"
        leave-to-class="translate-x-full opacity-0"
        class="fixed top-4 right-4 z-50 space-y-4 w-full max-w-xs">
        <ToastListItem
            v-for="(item, index) in items"
            :key="item.key"
            :message="item.message"
            :type="item.type"
            @remove="remove(index)"/>
    </TransitionGroup>
</template>
