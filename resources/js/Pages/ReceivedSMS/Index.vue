<template>
    <div>
        <Head title="Received SMSs" />
        <Authenticated>
            <ReceivedSMSTable :smss="smss" />
        </Authenticated>
    </div>
</template>
<script setup>
import Authenticated from "@/Layouts/Authenticated.vue";
import { Head } from "@inertiajs/inertia-vue3";
import ReceivedSMSTable from "@/Components/Tables/ReceivedSMSTable.vue";

defineProps({
    smss: Object,
})
</script>
