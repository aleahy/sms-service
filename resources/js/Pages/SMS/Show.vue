<template>
    <Authenticated>
        <Head title="SMS" />
        <div class="flex">
            <div class="w-1/2 p-4">
                <h1 class="text-lg">Message Received</h1>
                <ViewSMSMessage :sms="sms" />
            </div>
            <div class="p-4 w-1/2">
                <h1 class="text-lg">Send Reply</h1>
                <SendSMS :recipient="sms.sender" from="sms.to_phone_number" />

            </div>
        </div>
    </Authenticated>
</template>

<script setup>
import Authenticated from "@/Layouts/Authenticated.vue";
import { Head } from "@inertiajs/inertia";
import Button from '@/Components/Button.vue';
import FormBox from "@/Components/FormComponents/FormBox.vue";
import {useForm} from "@inertiajs/inertia-vue3";
import TextArea from "@/Components/FormComponents/TextArea.vue";
import ViewSMSMessage from "@/Components/ViewSMSMessage.vue";
import SendSMS from "@/Components/Forms/SMS/SendSMS.vue";
const props = defineProps({
    sms: Object,
});

const replyForm = useForm({
    to: props.sms.sender.id,
    from: props.sms.to_phone_number,
    message: ''
});

function sendReply() {
    replyForm.post(route('sms.store'));
}
</script>
