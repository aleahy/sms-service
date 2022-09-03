<script setup>
import { onMounted, ref } from 'vue';

defineProps({
    modelValue: String,
    label: String,
    id: String,
    placeholder: String,
    type: {
        type: String,
        default: 'text',
        required: false,
    }
});

defineEmits(['update:modelValue']);

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});
</script>

<template>
    <div>
        <label v-if="label" :for="id" class="block text-sm font-medium text-gray-700">{{ label }}</label>
        <div class="mt-1">
            <input  :type="type" :id="id" :placeholder="placeholder" :value="modelValue" @input="$emit('update:modelValue', $event.target.value)" ref="input"
                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
            >
        </div>
    </div>
</template>
