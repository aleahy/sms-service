
<template>
    <div>
        <div>
            <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                <button type="button" @click="showModal = true" class="inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto">Add user</button>
            </div>
        </div>

        <Modal v-model="showModal">
            <h1 class="text-lg font-semibold">Create a User</h1>
            <form @submit.prevent="submit">
                <LabelledInput label="Name" id="user_name" placeholder="Name" v-model="form.name" class="mt-2"/>

                <LabelledInput type="email" label="Email" id="user_email" placeholder="Email" v-model="form.email" class="mt-5" />

                <LabelledInput label="Webhook URL(optional)" id="user_webhook" placeholder="URL" v-model="form.webhook_url" class="mt-5"/>

               <ConfirmCancel confirm-button-text="Create User"  @cancel="showModal = false" :loading="form.loading" class="mt-5 sm:mt-8 "/>
            </form>
        </Modal>
    </div>
</template>
<script setup>

import {ref} from "vue";
import Modal from "@/Components/Modals/Modal.vue";
import ConfirmCancel from "@/Components/Modals/ConfirmCancel.vue";
import Input from "@/Components/Input.vue";
import LabelledInput from "@/Components/FormComponents/LabelledInput.vue";
import useAxiosForm from "@/Composables/useAxiosForm.js";
import {useForm} from "@inertiajs/inertia-vue3";
import {Inertia} from "@inertiajs/inertia";

const showModal = ref(false);
// const form = useForm({
//     name: '',
//     email: '',
//     webhook_url: '',
// });
const form = useAxiosForm({
    name: '',
    email: '',
    webhook_url: '',
});
function submit() {
    form.post(route('users.store'))
        .then(response => {

            Inertia.reload();
        })
    // form.post(route('users.store'), {
    //     preserveScroll: true,
    //     onSuccess: () => {
    //         showModal.value = false;
    //         form.reset();
    //     }
    // })



}
</script>
