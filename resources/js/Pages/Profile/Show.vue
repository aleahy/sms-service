<template>
    <AuthLayout>
        <Head>
            <title>Profile - {{ user.name }}</title>
        </Head>

        <div class="mx-0 md:mx-6 my-6">
            <UpdateUser :user="user" />

            <Separator />

            <UpdatePassword :password_status="password_status"/>
        </div>
    </AuthLayout>
</template>
<script setup>
import {Head, useForm} from '@inertiajs/inertia-vue3';
import AuthLayout from "@/Layouts/Authenticated.vue";
import LabelledInput from "@/Components/FormComponents/LabelledInput.vue";
import UpdateUser from "@/Components/Forms/Users/UpdateUser.vue";
import Separator from "@/Components/Separator.vue";
import UpdatePassword from "@/Components/Forms/Profile/UpdatePassword.vue";
import UpdateWebhook from "@/Components/Forms/Users/UpdateWebhook.vue";
import UpdateAPIToken from "@/Components/Forms/Users/UpdateAPIToken.vue";
import DeleteReceivedSMS from "@/Components/Forms/Users/DeleteReceivedSMS.vue";

const props = defineProps({
    user: Object,
    password_status: String,
})

</script>
