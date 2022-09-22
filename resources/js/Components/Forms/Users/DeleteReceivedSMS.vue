<template>
    <div>
        <div class="md:grid md:grid-cols-3 md:gap-6">
            <div class="md:col-span-1">
                <div class="px-4 sm:px-0">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Delete Received SMSs</h3>
                    <p class="mt-1 text-sm text-gray-600">Delete all the SMSs that have been received from this client.</p>
                </div>
            </div>
            <div class="mt-5 md:col-span-2 md:mt-0">
                <FormBox @submit.prevent="deleteSMSs" class="text-sm text-gray-600">
                    This client has sent {{ smsCount }} SMSs
                    <template v-slot:footer>
                        <ConfirmCancelModal :disabled="!smsCount" button-text="Delete SMSs" :loading="form.processing" @confirm="deleteSMSs" ref="confirmModal">
                            Are you sure you want to delete all of the SMSs from this client?
                        </ConfirmCancelModal>
                    </template>
                </FormBox>
            </div>
        </div>

    </div>
</template>

<script setup>
import FormBox from "@/Components/FormComponents/FormBox.vue";
import Button from "@/Components/Button.vue";
import {useForm} from "@inertiajs/inertia-vue3";
import axios from "axios";
import {Inertia} from "@inertiajs/inertia";

import ConfirmCancelModal from "@/Components/Modals/ConfirmCancelModal.vue";
import {ref} from "vue";


const props = defineProps({
    smsCount: Number,
    user_id: Number,
});
const form = useForm({});
const confirmModal = ref(null);

function deleteSMSs() {
    form.delete(route('users.sms.delete', { user: props.user_id}), {
        preserveScroll: true,
        onSuccess: () => {
            confirmModal.value.close();
        }
    });
}
</script>

