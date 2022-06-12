<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import JetButton from '@/Jetstream/Button.vue';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { Inertia } from '@inertiajs/inertia';

let props = defineProps({
    data: Object,
});

let selectDay = () => {
    alert("helloWorld");
}

let attachRole = (shiftid, shiftroleid) => {
    Inertia.post("/shifts/attach/" + shiftid, { shiftrole_id: shiftroleid });
}

let detachRole = (shiftid, shiftroleid) => {
    Inertia.post("/shifts/detach/" + shiftid, { shiftrole_id: shiftroleid });
}

let day = "day1";
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <div class="sm:flex justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Helfen
                </h2>
                <ul class="list-reset flex flex-wrap mt-2 text-right">
                    <li class="mr-3">
                        <a href="">Meine Schichten</a>
                    </li>
                    <li class="mr-3">
                        Offene Schichten
                    </li>
                    <li class="mr-3">
                        Info
                    </li>
                </ul>
            </div>
            <ul class="list-reset flex flex-wrap mt-5 justify-center">
                <li class="mr-3">
                    <JetButton class="" :class="day == 'day0' ? 'list-button-active' : ''" @click="selectDay('day0')">
                        Do, 30.06.</JetButton>
                </li>
                <li class="mr-3">
                    <button class="list-button" v-bind:class="day == 'day1' ? 'list-button-active' : ''"
                        @click="selectDay('day1')">Fr, 01.07.</button>
                </li>
                <li class="mr-3">
                    <button class="list-button" v-bind:class="day == 'day2' ? 'list-button-active' : ''"
                        @click="selectDay('day2')">Sa, 02.07</button>
                </li>
                <li class="mr-3">
                    <button class="list-button" v-bind:class="day == 'day3' ? 'list-button-active' : ''"
                        @click="selectDay('day3')">So, 03.07</button>
                </li>
                <li class="mr-3">
                    <button class="list-button" v-bind:class="day == 'day4' ? 'list-button-active' : ''"
                        @click="selectDay('day4')">Mo, 04.07</button>
                </li>
            </ul>
        </template>
        <div class="max-w-7xl mx-auto pt-4 px-1 sm:px-4 lg:px-8">


            <div class="flex flex-wrap -mx-1 lg:-mx-4">
                <div v-for="shift in data" class="my-1 px-1 w-full sm:w-1/2 lg:w-1/3 lg:my-4 lg:px-2 xl:w-1/4 mb-6">
                    <article class="bg-white overflow-hidden rounded-lg shadow-md h-full">
                        <header class="flex justify-between leading-tight p-2 min-height-card">
                            <h1 class="text-lg">
                                <span class="text-black">{{ shift.name }}</span>
                            </h1>
                        </header>
                        <div class="flex justify-between px-2 pb-1">
                            <span class="font-bold text-grey-darker">{{ shift.category }}</span>
                            <span>{{ shift.time }}h ({{ shift.duration }}min)</span>
                        </div>

                        <footer class="p-2">
                            <div v-for="shiftrole in shift.shiftroles"
                                class="flex items-center text-black mb-1 border-b">
                                <p class="flex-1 ml-2 mr-2">
                                    {{ shiftrole.name }}
                                    <span class="text-xs">({{ shiftrole.found }}/{{ shiftrole.allowed }})</span>
                                    <br>
                                    <span v-for="user in shiftrole.users" class="text-sm">
                                        <a :href="'/teilnehmerinnen/#' + user.id" class="link"> {{ user.name }},</a>
                                    </span>
                                </p>

                                <JetButton v-if="shiftrole.status == 'open'" @click="attachRole(shift.id, shiftrole.id)"
                                    class="ml-4 bg-lime-700">
                                    <font-awesome-icon icon="fa-solid fa-handshake-angle" class="-ml-1 mr-3 h-5 w-5" />
                                    Helfen
                                </JetButton>

                                <JetButton v-if="shiftrole.status == 'assigned'"
                                    @click="detachRole(shift.id, shiftrole.id)" class="bg-red-800">
                                    <font-awesome-icon icon="fa-solid fa-sign-out-alt" class="-ml-1 mr-3 h-4 w-4" />
                                    Verlassen
                                </JetButton>

                                <JetButton class="inline-block bg-grey border-grey" v-if="shiftrole.status == 'full'">
                                    Full
                                </JetButton>
                            </div>
                        </footer>
                        <span class="list-card-header text-black" v-html="shift.description"></span>
                    </article>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
