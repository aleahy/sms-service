<template>
    <IndexTable :meta="smss.meta" table-fixed>
        <TableHeader>
            <TableHeaderCell class="text-left w-1/6">Received At</TableHeaderCell>
            <TableHeaderCell class="w-1/6 text-left">From</TableHeaderCell>
            <TableHeaderCell class="w-1/6 text-left">To</TableHeaderCell>
            <TableHeaderCell class="w-1/2 text-left">Message</TableHeaderCell>
        </TableHeader>

        <TableBody>
            <TableBodyRow v-for="sms in smss.data" :key="sms.id" class="hover:bg-gray-50">
                <TableBodyCell class="w-1/6">{{ sms.created_at }}</TableBodyCell>
                <TableBodyCell  class="w-1/6">{{ sms?.sender.name ?? sms.from_phone_number }}</TableBodyCell>
                <TableBodyCell  class="w-1/6">{{ sms.to_phone_number }}</TableBodyCell>
                <TableBodyCell class="truncate w-1/2">{{ sms.message }}</TableBodyCell>
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
