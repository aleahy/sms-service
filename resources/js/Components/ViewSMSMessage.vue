<template>
    <div class="bg-white p-8 rounded-lg shadow border border-gray-50 mt-3">
        <div class="">
            <div>Date</div>
            <div class="border p-4 rounded-lg mt-2 shadow">{{ sms.created_at }}</div>
        </div>
        <div class="mt-4">
            <div>From</div>
            <div class="border p-4 rounded-lg mt-2 shadow">{{ sms?.sender.name ?? sms.from_phone_number }}</div>
        </div>
        <div class="mt-4">
            <div>To</div>
            <div class="border p-4 rounded-lg mt-2 shadow">{{ sms.recipient?.name ?? sms.to_phone_number}}</div>
        </div>
        <div class="mt-4">
            <div>Message</div>
            <div class="border p-4 rounded-lg mt-2 shadow">{{ sms.message }}</div>
        </div>
    </div>
</template>
<script setup>
defineProps({
    sms: Object,
})
</script>
