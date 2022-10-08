<template>
    <div>
        <div class="md:grid md:grid-cols-3 md:gap-6">
            <div class="md:col-span-1">
                <div class="px-4 sm:px-0">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Password</h3>
                    <p class="mt-1 text-sm text-gray-600">Update your password.</p>
                </div>
            </div>
            <div class="mt-5 md:col-span-2 md:mt-0">
                <form @submit.prevent="save">
                    <div class="shadow sm:overflow-hidden sm:rounded-md">
                        <div class="space-y-6 bg-white px-4 py-5 sm:p-6">
                            <div>
                                <LabelledInput type="password" label="Current Password" id="current_password" placeholder="Password" v-model="passwordForm.current_password" :error="passwordForm.errors.current_password" autocomplete="current-password" class="mt-2"/>
                                <LabelledInput type="password" label="New Password" id="password" placeholder="New Password" v-model="passwordForm.password" :error="passwordForm.errors.password" autocomplete="new-password" class="mt-2"/>
                                <LabelledInput type="password" label="Confirm Password" id="password_confirmation" placeholder="Password Confirmation" v-model="passwordForm.password_confirmation" :error="passwordForm.errors.password_confirmation" autocomplete="new-password" class="mt-2"/>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 flex items-center justify-between">
                            <span class="text-gray-500">{{ password_status }}</span>
                            <Button>Update</Button>
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
import Button from '@/Components/Button.vue';
const props = defineProps({
    password_status: String,
})
const passwordForm = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
})

function save() {
    passwordForm.patch('/profile/password', {
        onSuccess: () => { passwordForm.reset(); },
    })
}
</script>
