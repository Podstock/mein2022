<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm } from '@inertiajs/inertia-vue3'
import JetButton from '@/Jetstream/Button.vue';
import { Inertia } from '@inertiajs/inertia'


let props = defineProps({
    drivings: Object,
    user: Object
});

const form = useForm({
    day: "Anreise Fr 1. Juli",
    time: "",

});

let deleteDriver = (id) => {
    Inertia.delete("/driving_services/" + id, {
        onBefore: () => confirm('Möchtest du den Eintrag wirklich löschen?'),
        preserveScroll: true,
    });

}

</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Fahrdienst
            </h2>
        </template>

        <div class="max-w-7xl mx-auto pt-4 px-1 sm:px-4 lg:px-8">

            <div class="my-8 flex flex-col">
                <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                        <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-300">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col"
                                            class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                                            Name</th>
                                        <th scope="col"
                                            class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                            Tag</th>
                                        <th scope="col"
                                            class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                            Uhrzeit</th>
                                        <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                            <span class="sr-only">Delete</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 bg-white">
                                    <tr v-for="service in drivings.data" :key="service.id">
                                        <td
                                            class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                            {{ service.name }}</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ service.day }}
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ service.time }}
                                        </td>
                                        <td
                                            class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                            <a v-if="service.user_id == user.id" href="#" @click="deleteDriver(service.id)" class="text-indigo-600 hover:text-indigo-900">Löschen<span
                                                    class="sr-only">, {{ service.name }}</span></a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <h3 class="text-lg">Ich muss zum/vom Bahnhof "Alfeld" abgeholt/gebracht werden...</h3>
            <form @submit.prevent="form.post('/driving_services')" class="w-full border-t pt-6">
                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2"
                            for="grid-state">Am</label>
                        <div class="relative">
                            <select
                                class="block appearance-none w-full bg-grey-lighter border border-grey-lighter text-grey-darker py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-grey"
                                id="grid-state" v-model="form.day">
                                <option>Anreise Do 30. Juni</option>
                                <option>Anreise Fr 1. Juli</option>
                                <option>Abreise So 3. Juli</option>
                                <option>Abreise Mo 4. Juli</option>
                            </select>
                        </div>
                    </div>
                    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2"
                            for="grid-first-name">Uhrzeit</label>
                        <input
                            class="appearance-none block w-full bg-grey-lighter text-grey-darker rounded py-3 px-4 mb-3 leading-tight focus:outline-none"
                            id="grid-first-name" type="text" placeholder="15:00h" v-model="form.time">
                        <span class="text-sm text-red-700 italic text-error" v-if="form.errors.time"
                            v-text="form.errors.time"></span>
                    </div>
                </div>
                <JetButton>Speichern</JetButton>
            </form>
        </div>
    </AppLayout>
</template>
