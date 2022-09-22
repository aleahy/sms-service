<template>
    <AuthLayout>
        <Head>
            <title>User - {{ user.name }}</title>
        </Head>

        <div class="mx-0 md:mx-6 my-6">
            <UpdateUser :user="user" />

            <Separator />

            <UpdateWebhook :user_id="user.id" :webhook="user.webhook" class="mt-6 md:mt-0"/>

            <Separator />

            <UpdateAPIToken :user_id="user.id" :tokens="user.tokens" class="mt-6 md:mt-0"/>

            <Separator />

            <DeleteReceivedSMS :user_id="user.id" :sms-count="user.received_sms_count"  class="mt-6 md:mt-0"/>

        </div>
    </AuthLayout>
</template>
<script setup>
import {Head, useForm} from '@inertiajs/inertia-vue3';
import AuthLayout from "@/Layouts/Authenticated.vue";
import LabelledInput from "@/Components/FormComponents/LabelledInput.vue";
import UpdateUser from "@/Components/Forms/Users/UpdateUser.vue";
import Separator from "@/Components/Separator.vue";
import UpdateWebhook from "@/Components/Forms/Users/UpdateWebhook.vue";
import UpdateAPIToken from "@/Components/Forms/Users/UpdateAPIToken.vue";
import DeleteReceivedSMS from "@/Components/Forms/Users/DeleteReceivedSMS.vue";

const props = defineProps({
    user: Object,
})
const userForm = useForm({
    name: props.user.name,
    email: props.user.email,
})
</script>
