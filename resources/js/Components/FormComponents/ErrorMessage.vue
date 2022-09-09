<template>
    <div v-show="error" >
        <p class="text-xs text-red-500">{{ error }}</p>
    </div>
</template>
<script setup>
defineProps({
    error: String,
})
</script>
