<template>
    <div class="px-4 sm:px-6 lg:px-8 mt-8 ">
        <div class="flex flex-col">
            <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                    <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-300" :class="{ 'table-fixed w-full': tableFixed}">
                            <slot></slot>
                        </table>
                        <Pagination :meta="meta" />
                    </div>
                </div>
            </div>

        </div>

    </div>
</template>
<script setup>
import Pagination from "@/Components/Pagination.vue";

defineProps({
    meta: Object,
    tableFixed: Boolean,
});
</script>
