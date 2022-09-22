<template>
    <form>
        <div class="shadow sm:overflow-hidden sm:rounded-md">
            <div class="space-y-6 bg-white px-4 py-5 sm:p-6">
               <slot></slot>
            </div>
            <div class="bg-gray-50 px-4 py-3 text-right sm:px-6">
                <slot name="footer"></slot>
            </div>
        </div>
    </form>
</template>
<script setup>
</script>
