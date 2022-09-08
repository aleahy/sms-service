<template>
    <div>
        <div class="md:grid md:grid-cols-3 md:gap-6">
            <div class="md:col-span-1">
                <div class="px-4 sm:px-0">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">API Token</h3>
                    <p class="mt-1 text-sm text-gray-600">An API Token is required to send an SMS to this app.</p>
                </div>
            </div>
            <div class="mt-5 md:col-span-2 md:mt-0">
                <form @submit.prevent="save">
                    <div class="shadow sm:overflow-hidden sm:rounded-md">
                        <div class="space-y-6 bg-white px-4 py-5 sm:p-6">
                            <div>
                                <h2 class="text-sm text-gray-600">API Token</h2>
                                <div class="mt-1">
                                    <div v-if="tokens.length > 0 && !token">
                                        <div v-for="apiToken in tokens" :key="apiToken.id" class="flex justify-between text-sm text-gray-600 mt-1">
                                            <div>{{ apiToken.name }}</div>
                                            <div>Created at {{ apiToken.created_at }}</div>
                                            <form @submit.prevent="deleteToken(apiToken.id)">
                                                <button type="submit" class="text-xs text-indigo-600 hover:text-indigo-900">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                    <div v-else-if="!token" class="text-gray-600 text-sm">
                                        There are currently no tokens
                                    </div>
                                </div>
                                <div v-if="token">
                                    <div class="text-sm text-gray-600 mt-1 border inline-block py-2 px-8 rounded">{{ token }}</div>
                                    <div class="mt-2 text-xs">Put this token in a safe place. You will not be able to retrieve it if you lose it.</div>
                                </div>

                            </div>

                        </div>
                        <div class="bg-gray-50 px-4 py-3 text-right sm:px-6">
                            <Button>Generate New API Token</Button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
<script setup>
import LabelledInput from '@/Components/FormComponents/LabelledInput.vue';
import Button from '@/Components/Button.vue';
import useAxiosForm from "@/Composables/useAxiosForm.js";
import {ref} from "vue";
import { Inertia } from "@inertiajs/inertia";


const props = defineProps({
    tokens: Object,
    user_id: Number
})
const form = useAxiosForm();
const token = ref();

function deleteToken(token_id) {
    Inertia.delete(route('users.sms-token.delete', { user: props.user_id, token: token_id}), {
        preserveScroll: true,
    });
}

function save() {
    form.post(route('users.sms-token.store', { user: props.user_id }))
        .then(response => {
            token.value = response.token;
        });
}


</script>
