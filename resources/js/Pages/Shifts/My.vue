<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import JetButton from '@/Jetstream/Button.vue';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { Link } from '@inertiajs/inertia-vue3'
import { Inertia } from '@inertiajs/inertia';

let props = defineProps({
    data: Object,
});

let detachRole = (shiftid, shiftroleid) => {
    Inertia.post("/shifts/detach/" + shiftid, { shiftrole_id: shiftroleid }, {
        onBefore: () => confirm('Möchtest du die Schicht wirklich verlassen?'),
    });
}
</script>


<template>
    <AppLayout title="Helfen - Info">
        <template #header>
            <div class="sm:flex justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Helfen
                </h2>
                <ul class="list-reset flex flex-wrap mt-2 text-right">
                    <li class="mr-3">
                        <Link href="/myshifts" class="font-bold">Meine Schichten</Link>
                    </li>
                    <li class="mr-3">
                        <Link href="/shifts/day1">Offene Schichten</Link>
                    </li>
                    <li class="mr-3">
                        <Link href="/shiftroles">Info</Link>
                    </li>
                </ul>
            </div>
        </template>

        <div v-if="data.length == 0" class="text-center mt-8">
            <h3 class="mt-2 text-base font-medium text-gray-900">Du hast noch keine Schichten ausgewählt</h3>
            <div class="mt-6">
                <Link href="/shifts/day1"
                    class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-base font-medium rounded-md text-white bg-lime-600 hover:bg-lime-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-lime-500">
                <!-- Heroicon name: solid/plus -->
                <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                    fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd"
                        d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                        clip-rule="evenodd" />
                </svg>
                Offene Schichten
                </Link>
            </div>
        </div>

        <div class="max-w-7xl mx-auto pt-4 px-1 sm:px-4 lg:px-8">
            <div class="py-4" v-for="day in data">
                <div class="w-full font-bold border-b pb-2" :key="day.name" v-if="day.name == 'day-1'">Mi, 29.06.</div>
                <div class="w-full font-bold border-b pb-2" :key="day.name" v-if="day.name == 'day0'">Do, 30.06.</div>
                <div class="w-full font-bold border-b pb-2" :key="day.name" v-if="day.name == 'day1'">Fr, 01.07.</div>
                <div class="w-full font-bold border-b pb-2" :key="day.name" v-if="day.name == 'day2'">Sa, 02.07.</div>
                <div class="w-full font-bold border-b pb-2" :key="day.name" v-if="day.name == 'day3'">So, 03.07.</div>
                <div class="w-full font-bold border-b pb-2" :key="day.name" v-if="day.name == 'day4'">Mo, 04.07.</div>
                <div class="flex flex-wrap -mx-1 lg:-mx-4 mt-1">
                    <div v-for="shift in day.shifts.data"
                        class="my-1 px-1 w-full sm:w-1/2 lg:w-1/3 lg:my-4 lg:px-2 xl:w-1/4 mb-6">
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
                                    <p class="flex-1 ml-2 mr-2">{{ shiftrole.name }}</p>

                                    <JetButton v-if="shiftrole.status == 'assigned'"
                                        @click="detachRole(shift.id, shiftrole.id)" class="bg-red-800">
                                        <font-awesome-icon icon="fa-solid fa-sign-out-alt" class="-ml-1 mr-3 h-4 w-4" />
                                        Verlassen
                                    </JetButton>
                                </div>
                            </footer>
                        </article>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
