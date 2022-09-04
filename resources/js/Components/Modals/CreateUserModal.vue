
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
                <LabelledInput label="Name" id="user_name" placeholder="Name" v-model="form.name" :error="form.errors.name" class="mt-2"/>

                <LabelledInput type="email" label="Email" id="user_email" placeholder="Email" v-model="form.email" :error="form.errors.email" class="mt-5" />

               <ConfirmCancel confirm-button-text="Create User"  @cancel="cancel" :loading="form.processing" class="mt-5 sm:mt-8 "/>
            </form>
        </Modal>
    </div>
</template>
<script setup>

import {ref} from "vue";
import Modal from "@/Components/Modals/Modal.vue";
import ConfirmCancel from "@/Components/Modals/ConfirmCancel.vue";
import LabelledInput from "@/Components/FormComponents/LabelledInput.vue";
import {useForm} from "@inertiajs/inertia-vue3";

const showModal = ref(false);
const form = useForm({
    name: '',
    email: '',
});

function cancel() {
    showModal.value = false;
    form.reset();
    form.clearErrors();
}

function submit() {
    form.post(route('users.store'), {
        preserveScroll: true,
        onSuccess: () => {
            showModal.value = false;
            form.reset();
        }
    })
}
</script>
