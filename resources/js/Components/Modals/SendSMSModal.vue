
<template>
    <div>
        <div>
            <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                <button type="button" @click="showModal = true" class="inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto">Reply</button>
            </div>
        </div>

        <Modal v-model="showModal">
            <h1 class="text-lg font-semibold">Send Reply</h1>
            <form @submit.prevent="submit">
                <div>
                    <div>To</div>
                    <div class="border p-4 rounded-lg mt-2 shadow text-gray-500">{{ recipient.name }}</div>
                    <ErrorMessage :error="replyForm.errors.recipient_id" class="mt-2"/>
                </div>
                <div class="mt-4">
                    <div>Message</div>
                    <TextArea v-model="replyForm.message" class="w-full h-48 mt-2"/>
                    <ErrorMessage :error="replyForm.errors.message" />
                </div>

                <ConfirmCancel confirm-button-text="Send"  @cancel="cancel" :loading="replyForm.processing" class="mt-5 sm:mt-8 "/>
            </form>
        </Modal>
    </div>
</template>
<script setup>

import {ref} from "vue";
import Modal from "@/Components/Modals/Modal.vue";
import ConfirmCancel from "@/Components/Modals/ConfirmCancel.vue";
import ErrorMessage from "@/Components/FormComponents/ErrorMessage.vue";
import {useForm} from "@inertiajs/inertia-vue3";
import TextArea from "@/Components/FormComponents/TextArea.vue";

const props = defineProps({
    recipient: Object,
    from: String,
});

const showModal = ref(false);
const replyForm = useForm({
    recipient_id: props.recipient.id,
    from: props.from,
    message: ''
});

function cancel() {
    showModal.value = false;
    replyForm.reset('message');
    replyForm.clearErrors();
}

function submit() {
    replyForm.post(route('sms.store'), {
        onSuccess: () => {
            showModal.value = false;
            replyForm.reset('message');
        }
    } );
}
</script>
