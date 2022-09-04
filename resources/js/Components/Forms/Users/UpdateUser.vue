<template>
    <div>
        <div class="md:grid md:grid-cols-3 md:gap-6">
            <div class="md:col-span-1">
                <div class="px-4 sm:px-0">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Details</h3>
                </div>
            </div>
            <div class="mt-5 md:col-span-2 md:mt-0">
                <form @submit.prevent="save">
                    <div class="shadow sm:overflow-hidden sm:rounded-md">
                        <div class="space-y-6 bg-white px-4 py-5 sm:p-6">
                            <div>
                                <LabelledInput label="Name" id="user_name" placeholder="Name" v-model="userForm.name" :error="userForm.errors.name" class="mt-2"/>
                                <LabelledInput type="email" label="Email" id="user_email" placeholder="Email" v-model="userForm.email" :error="userForm.errors.email" class="mt-5" />
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 text-right sm:px-6">
                            <button type="submit" class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
<script setup>
import LabelledInput from '@/Components/FormComponents/LabelledInput.vue'
import {useForm} from "@inertiajs/inertia-vue3";

const props = defineProps({
    user: Object,
})
const userForm = useForm({
    name: props.user.name,
    email: props.user.email,
})

function save() {
    userForm.patch(route('users.update', { user: props.user }));
}
</script>
