

<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="w-1/2 bg-white rounded-lg">
                    <div class="border-b border-gray-200 px-4 py-5 sm:px-6">
                        <div class="-ml-4 -mt-2 flex flex-wrap items-center justify-between sm:flex-nowrap">
                            <div class="ml-4 mt-2">
                                <h3 class="text-lg font-medium leading-6 text-gray-900">Most Recent Received SMS</h3>
                            </div>

                        </div>
                    </div>
                    <div class="px-6 py-5">
                        <div class="flex justify-between items-baseline">
                            <div class="font-semibold">{{ most_recent_received.sender.name }}</div>
                            <div class="text-xs">{{ most_recent_received.created_at_diff }}</div>
                        </div>
                        <div class="mt-1">To: {{ most_recent_received.to_phone_number }}</div>
                        <div class="mt-3">{{ most_recent_received.message }}</div>

                        <div class="flex justify-end mt-4">
                            <SendSMSModal :recipient="most_recent_received.sender" :from="most_recent_received.to_phone_number"/>
                        </div>
                    </div>

                </div>
                <div>

                </div>

            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head } from '@inertiajs/inertia-vue3';
import SendSMSModal from "@/Components/Modals/SendSMSModal.vue";

defineProps({
    most_recent_received: Object,
})
</script>
