<template>
    <textarea :value="modelValue" @input="$emit('update:modelValue', $event.target.value)" ref="ta"
              class="border-gray-300 rounded-lg shadow resize-none focus:outline-none focus:ring-2 focus:ring-indigo-500" />
</template>
<script setup>
import {onMounted, ref} from "vue";

defineEmits(['update:modelValue']);
defineProps({
    modelValue: String,
});

const ta = ref(null);

onMounted(() => {
    if (ta.value.hasAttribute('autofocus')) {
        ta.value.focus();
    }
});
</script>
