<template>
    <div>
        <div>
            <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                <button type="button" :disabled="disabled" @click="showModal = true" class="inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto disabled:hover:bg-indigo-600 disabled:opacity-50">{{ buttonText}}</button>
            </div>
        </div>

        <Modal v-model="showModal">
            <h1 class="text-lg font-semibold">{{ title ?? 'Are you sure?' }}</h1>
               <slot></slot>

               <ConfirmCancel :confirm-button-text="buttonText" @cancel="cancel" @confirm="$emit('confirm')" :loading="loading" class="mt-5 sm:mt-8 "/>
        </Modal>
    </div>
</template>
<script setup>
import {ref} from "vue";
import ConfirmCancel from '@/Components/Modals/ConfirmCancel.vue';
import Modal from '@/Components/Modals/Modal.vue';
defineProps({
    buttonText: String,
    loading: Boolean,
    title: String,
    disabled: Boolean,
})
const emit = defineEmits(['confirm', 'cancel']);
const showModal = ref(false);

function cancel() {
    showModal.value = false;
    emit('cancel');
}

function confirm() {
    emit('confirm');
}

const close = () => {
    showModal.value = false;
}

defineExpose({
    close,
});
</script>
