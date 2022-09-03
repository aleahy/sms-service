<template>
    <AuthLayout>
        <Head title="Users" />

        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Users
            </h2>
        </template>

        <div class="mt-8 sm:flex sm:items-center">
            <CreateUserModal />
        </div>
        <UserTable :users="users"/>
    </AuthLayout>
</template>
<script setup>
import AuthLayout from '@/Layouts/Authenticated.vue';
import { Head } from '@inertiajs/inertia-vue3';
import UserTable from "@/Components/Tables/UserTable.vue";
import CreateUserModal from "@/Components/Modals/CreateUserModal.vue";

defineProps({
    users: Object,
})
</script>
