<!-- This example requires Tailwind CSS v2.0+ -->
<template>
    <div class="px-4 sm:px-6 lg:px-8 mt-8 ">
        <div class="flex flex-col">
            <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                    <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-300">
                            <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Name</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Email</th>
                                <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                    <span class="sr-only">Action</span>
                                </th>
                            </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                            <tr v-for="user in users.data" :key="user.id">
                                <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">{{ user.name }}</td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ user.email }}</td>
                                <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                    <Link :href="user.link" class="text-indigo-600 hover:text-indigo-900"
                                    >Details<span class="sr-only">, {{ user.name }}</span></Link
                                    >
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <Pagination :meta="users.meta" />
                    </div>
                </div>
            </div>

        </div>

    </div>
</template>

<script setup>
import Pagination from "@/Components/Pagination.vue";
import { Link } from "@inertiajs/inertia-vue3";

defineProps({
    users: Object,
})
</script>
