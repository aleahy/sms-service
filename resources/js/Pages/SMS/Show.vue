<template>
    <Authenticated>
        <Head title="SMS" />
        <div class="flex">
            <div class="w-1/2 p-4">
                <h1 class="text-lg">Message Received</h1>
                <div class="bg-white p-8 rounded-lg shadow border border-gray-50 mt-3">
                    <div class="">
                        <div>Date</div>
                        <div class="border p-4 rounded-lg mt-2 shadow">{{ sms.created_at }}</div>
                    </div>
                    <div class="mt-4">
                        <div>From</div>
                        <div class="border p-4 rounded-lg mt-2 shadow">{{ sms?.sender.name ?? sms.from_phone_number }}</div>
                    </div>
                    <div class="mt-4">
                        <div>To</div>
                        <div class="border p-4 rounded-lg mt-2 shadow">{{ sms.recipient?.name ?? sms.to_phone_number}}</div>
                    </div>
                    <div class="mt-4">
                        <div>Message</div>
                        <div class="border p-4 rounded-lg mt-2 shadow">{{ sms.message }}</div>
                    </div>
                </div>
            </div>
            <div class="p-4 w-1/2">
                <h1 class="text-lg">Send Reply</h1>

                <FormBox>
                    <div>
                        <div>To</div>
                        <div class="border p-4 rounded-lg mt-2 shadow text-gray-500">{{ sms.sender.name }}</div>
                    </div>
                    <div class="mt-4">
                        <div>Message</div>
                        <TextArea v-model="replyForm.message" class="w-full h-48 mt-2"/>
                    </div>
                    <template v-slot:footer>
                        <Button>Send</Button>
                    </template>
                </FormBox>
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
