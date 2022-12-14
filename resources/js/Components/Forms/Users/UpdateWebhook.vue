<template>
    <div>
        <div class="md:grid md:grid-cols-3 md:gap-6">
            <div class="md:col-span-1">
                <div class="px-4 sm:px-0">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Webhook</h3>
                    <p class="mt-1 text-sm text-gray-600">SMSs sent to this user will be sent via this webhook.</p>
                </div>
            </div>
            <div class="mt-5 md:col-span-2 md:mt-0">
                <form @submit.prevent="save">
                    <div class="shadow sm:overflow-hidden sm:rounded-md">
                        <div class="space-y-6 bg-white px-4 py-5 sm:p-6">
                            <div>
                                <LabelledInput label="Webhook" id="webhook" placeholder="Webhook" v-model="form.webhook_url" :error="form.errors.webhook_url" class="mt-2"/>
                            </div>
                            <div v-if="secret">
                                <h2 class="text-sm text-gray-600">Signing Secret</h2>
                                <div class="flex justify-between">
                                    <div class="text-sm text-gray-600 mt-1">{{ secret }}</div>
                                    <button type="button" @click.prevent="deleteWebhook" class="text-indigo-600 hover:text-indigo-900 text-sm">Delete</button>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 text-right sm:px-6">
                            <Button>Save</Button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
<script setup>
import LabelledInput from '@/Components/FormComponents/LabelledInput.vue'
import useAxiosForm from "@/Composables/useAxiosForm.js";
import { Inertia } from "@inertiajs/inertia";
import {ref} from "vue";
import Button from "@/Components/Button.vue";


const props = defineProps({
    webhook: Object,
    user_id: Number
})
const form = useAxiosForm({
    webhook_url: props.webhook?.url,
})
const secret = ref(props.webhook?.secret);

function save() {
    form.post(route('users.webhook.store', { user: props.user_id }))
        .then(response => {
            secret.value = response.secret;
        });
}

function deleteWebhook() {
    Inertia.delete(route('users.webhook.delete', { user: props.user_id}), {
        preserveScroll: true,
        onSuccess: () => {
            form.webhook_url = '';
            secret.value = '';
        }
    });
}
</script>
