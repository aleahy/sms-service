<template>
    <FormBox @submit.prevent="sendReply">
        <div>
            <div>To</div>
            <div class="border p-4 rounded-lg mt-2 shadow text-gray-500">{{ recipient.name }}</div>
        </div>
        <div class="mt-4">
            <div>Message</div>
            <TextArea v-model="replyForm.message" class="w-full h-48 mt-2"/>
        </div>
        <template v-slot:footer>
            <div class="flex justify-between items-center">
            <div>
                <Transition enter-from-class="opacity-0 duration-300"
                            enter-to-class="opacity-100 duration-300"
                            leave-from-class="opacity-100 duration-1000"
                            leave-to-class="opacity-0 duration-1000"
                >
                <span v-show="sentSuccessful">Message sent</span>
                </Transition>
            </div>
            <Button>Send</Button>
            </div>
        </template>
    </FormBox>
</template>
<script setup>
import {useForm} from "@inertiajs/inertia-vue3";
import FormBox from "@/Components/FormComponents/FormBox.vue";
import TextArea from "@/Components/FormComponents/TextArea.vue";
import Button from "@/Components/Button.vue";
import { ref } from "vue";
const props = defineProps({
    recipient: Object,
    from: String,
});

const replyForm = useForm({
    to: props.recipient.id,
    from: props.from,
    message: ''
});
const sentSuccessful = ref(false);

function sendReply() {
    replyForm.post(route('sms.store'), {
        onSuccess: () => {
            replyForm.reset('message');
            showSentMessage();
        }
    });
}

function showSentMessage() {
    sentSuccessful.value = true;
    const timeout = setTimeout(() => {
        sentSuccessful.value = false;
    }, 3000);
}
</script>
