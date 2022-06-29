<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';

let props = defineProps({
    vuser: Object
});
</script>

<template>
    <AppLayout title="User">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Visitenkarte
            </h2>
        </template>

        <div class="max-w-7xl mx-auto pt-4 px-1 sm:px-4 lg:px-8">
            <div class="flex flex-wrap -mx-1 lg:-mx-4">
                <article :id="vuser.data.id"
                    class="target:border-lime-600 target:border-4 overflow-hidden rounded-lg shadow-md h-full bg-white">
                    <img v-if="vuser.data.avatar" :src="vuser.data.avatar" class="block h-auto w-full" loading="lazy" />
                    <header class="flex items-center justify-between leading-tight px-2 md:px-4 py-2">
                        <h1 class="text-lg">
                            <span class="text-gray-900">{{ vuser.data.name }}</span>
                        </h1>
                    </header>
                    <div class="flex text-xs items-center px-2 md:px-4 border-b border-gray-300 pb-2">
                        <div v-if="vuser.data.twitter">
                            <a :href="'https://twitter.com/' + vuser.data.twitter" target="_blank">
                                <icon :icon="['fab', 'twitter']"></icon>
                                {{ vuser.data.twitter }}
                            </a>
                            <span class="ml-2">|</span>
                        </div>
                        <div v-if="vuser.data.sendegate" class="ml-2">
                            <a :href="'https://sendegate.de/u/' + vuser.data.sendegate" target="_blank">
                                {{ vuser.data.sendegate }}
                            </a>
                        </div>
                    </div>
                    <div class>
                        <div v-if="vuser.data.search" class="p-2 md:px-4 border-b border-gray-300">
                            <span class="font-bold">Ich suche:</span>
                            {{ vuser.data.search }}
                        </div>
                        <div v-if="vuser.data.offer" class="p-2 md:px-4 border-b border-gray-300">
                            <span class="font-bold">Ich biete:</span>
                            {{ vuser.data.offer }}
                        </div>
                    </div>
                    <footer class="p-2 md:p-4">
                        <a v-for="project in vuser.data.projects"
                            class="flex items-center no-underline hover:underline text-black mb-1" :href="project.url"
                            target="_blank">
                            <img v-if="project.logo" :src="project.logo" class="block h-12 w-12" />
                            <p class="ml-2 text-sm">{{ project.name }}</p>
                        </a>
                    </footer>
                </article>
            </div>
        </div>
    </AppLayout>
</template>
