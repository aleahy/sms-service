<!-- This example requires Tailwind CSS v2.0+ -->
<template>
    <div class="flex items-center justify-between border-t border-gray-200 bg-white px-4 py-3 sm:px-6">
        <div class="flex flex-1 justify-between sm:hidden">
            <a href="#" class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Previous</a>
            <a href="#" class="relative ml-3 inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Next</a>
        </div>
        <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
            <div>
                <p class="text-sm text-gray-700">
                    Showing
                    {{ ' ' }}
                    <span class="font-medium">{{ meta.from}}</span>
                    {{ ' ' }}
                    to
                    {{ ' ' }}
                    <span class="font-medium">{{ meta.to }}</span>
                    {{ ' ' }}
                    of
                    {{ ' ' }}
                    <span class="font-medium">{{ meta.total }}</span>
                    {{ ' ' }}
                    results
                </p>
            </div>
            <div>
                <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">

                    <component v-for="(link, index) of meta.links" :key="index"
                               :is="link.url  && !(link.label == link.current_page) ? Link : 'span'" :href="link.url"
                               preserve-scroll
                               :class="{
                                    'relative inline-flex items-center rounded-l-md border px-2 py-2 text-sm font-medium focus:z-20': index === 0,
                                    'relative inline-flex items-center border px-4 py-2 text-sm font-medium focus:z-20': index !== 0 && index !== meta.links.length -1,
                                    'relative inline-flex items-center rounded-r-md border px-2 py-2 text-sm font-medium focus:z-20': index === meta.links.length - 1,
                                    'z-10 bg-indigo-50 border-indigo-500 text-indigo-600': link.active,
                                    'bg-white border-gray-300 text-gray-500 hover:bg-gray-50': !link.active,
                                    'hover:bg-transparent': link.label === '...',
                               }"
                            >
                        <span v-if="index === 0">
                            <span class="sr-only">Previous</span>
                            <ChevronLeftIcon class="h-5 w-5" aria-hidden="true" />
                        </span>
                        <span v-else-if="index == meta.links.length - 1">
                            <span class="sr-only">Next</span>
                            <ChevronRightIcon class="h-5 w-5" aria-hidden="true" />
                        </span>
                        <span v-else>{{ link.label }}</span>
                    </component>
                </nav>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ChevronLeftIcon, ChevronRightIcon } from '@heroicons/vue/20/solid'
import { Link } from "@inertiajs/inertia-vue3";

defineProps({
    meta: Object,

})
</script>
