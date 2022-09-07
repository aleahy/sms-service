<template>
    <IndexTable :meta="smss.meta" table-fixed>
        <TableHeader>
            <TableHeaderCell>Received At</TableHeaderCell>
            <TableHeaderCell>From</TableHeaderCell>
            <TableHeaderCell>To</TableHeaderCell>
            <TableHeaderCell>Message</TableHeaderCell>
        </TableHeader>

        <TableBody>
            <TableBodyRow v-for="sms in smss.data" :key="sms.id">
                <TableBodyCell class="w-1/8">{{ sms.created_at }}</TableBodyCell>
                <TableBodyCell  class="w-1/8">{{ sms.from_phone_number }}</TableBodyCell>
                <TableBodyCell  class="w-1/8">{{ sms.to_phone_number }}</TableBodyCell>
                <TableBodyCell class="truncate w-5/8">{{ sms.message }}</TableBodyCell>
            </TableBodyRow>
        </TableBody>

    </IndexTable>

</template>

<script setup>
import IndexTable from "@/Components/TableComponents/IndexTable.vue";
import TableHeader from "@/Components/TableComponents/TableHeader.vue";
import TableHeaderCell from "@/Components/TableComponents/TableHeaderCell.vue";

import { Link } from "@inertiajs/inertia-vue3";
import { CheckCircleIcon } from "@heroicons/vue/20/solid";
import TableBody from "@/Components/TableComponents/TableBody.vue";
import TableBodyRow from "@/Components/TableComponents/TableBodyRow.vue";
import TableBodyCell from "@/Components/TableComponents/TableBodyCell.vue";

defineProps({
    smss: Object,
})
</script>
