<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import ScrollTop from '@/Partials/Top.vue';

let props = defineProps({
    users: Object
});
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Teilnehmer*innen
            </h2>
        </template>

        <div class="max-w-7xl mx-auto pt-4 px-1 sm:px-4 lg:px-8">
            <div class="flex flex-wrap -mx-1 lg:-mx-4">
                <div v-for="user in users.data" class="my-1 px-1 w-1/2 sm:w-1/3 md:w-1/4 lg:w-1/5 xl:w-1/6 lg:my-4 lg:px-4 mb-6"
                    :key="user.id">
                    <article :id="user.id" class="target:border-lime-600 target:border-4 overflow-hidden rounded-lg shadow-md h-full bg-white">
                        <img v-if="user.avatar" :src="user.avatar" class="block h-auto w-full" loading="lazy" />
                        <header class="flex items-center justify-between leading-tight px-2 md:px-4 py-2">
                            <h1 class="text-lg">
                                <span class="text-gray-900">{{ user.name }}</span>
                            </h1>
                        </header>
                        <div class="flex text-xs items-center px-2 md:px-4 border-b border-gray-300 pb-2">
                            <div v-if="user.twitter">
                                <a :href="'https://twitter.com/' + user.twitter" target="_blank">
                                    <icon :icon="['fab', 'twitter']"></icon>
                                    {{ user.twitter }}
                                </a>
                                <span class="ml-2">|</span>
                            </div>
                            <div v-if="user.sendegate" class="ml-2">
                                <a :href="'https://sendegate.de/u/' + user.sendegate" target="_blank">
                                    {{ user.sendegate }}
                                </a>
                            </div>
                        </div>
                        <div class>
                            <div v-if="user.search" class="p-2 md:px-4 border-b border-gray-300">
                                <span class="font-bold">Ich suche:</span>
                                {{ user.search }}
                            </div>
                            <div v-if="user.offer" class="p-2 md:px-4 border-b border-gray-300">
                                <span class="font-bold">Ich biete:</span>
                                {{ user.offer }}
                            </div>
                        </div>
                        <footer class="p-2 md:p-4">
                            <a v-for="project in user.projects"
                                class="flex items-center no-underline hover:underline text-black mb-1"
                                :href="project.url" target="_blank">
                                <img v-if="project.logo" :src="project.logo" class="block h-12 w-12" loading="lazy" />
                                <p class="ml-2 text-sm">{{ project.name }}</p>
                            </a>
                        </footer>
                    </article>
                </div>
            </div>
        </div>
    <ScrollTop />
    </AppLayout>
</template>
