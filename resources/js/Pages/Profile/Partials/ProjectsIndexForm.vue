<script setup>
import { ref, onMounted } from 'vue';
import { useForm } from '@inertiajs/inertia-vue3';
import JetButton from '@/Jetstream/Button.vue';
import JetFormSection from '@/Jetstream/FormSection.vue';
import JetInput from '@/Jetstream/Input.vue';
import JetInputError from '@/Jetstream/InputError.vue';
import JetLabel from '@/Jetstream/Label.vue';
import JetActionMessage from '@/Jetstream/ActionMessage.vue';
import AvatarCropper from 'vue-avatar-cropper';

const projects = ref();

async function new_project() {
    await axios.post('/projects', {});
    update();
}

async function destroy(project) {
    await axios.delete('/projects/' + project.id);
    update();
}

function uploaded(project) {
    save(project);
    update();
}

function save(project) {
    project.post('/projects/' + project.id, { preserveScroll: true });
}

function update() {
    axios.get('/projects').then(({ data }) => {
        projects.value = [];

        data.data.map((project, index) => {
            projects.value.push(useForm({
                _method: 'PUT',
                id: project.id,
                name: project.name,
                url: project.url,
                logo: project.logo
            }));
        });
    });
}

onMounted(() => {
    update();
});
</script>

<template>
    <h3 class="text-lg font-medium text-gray-900">
        Deine Projekte
    </h3>
    <JetFormSection @submitted="save(project)" v-for="(project, index) in projects" class="mb-6" key="project.id">
        <template #description v-if="index == 0">
            Aktualisiere deine Projekte
        </template>

        <template #form>
            <!-- Name -->
            <div class="col-span-6 sm:col-span-4">
                <JetLabel for="name" value="Projekt Name" />
                <JetInput id="name" v-model="project.name" type="text" class="mt-1 block w-full" />
                <JetInputError :message="project.errors.name" class="mt-2" />
            </div>
            <!-- URL -->
            <div class="col-span-6 sm:col-span-4">
                <JetLabel for="url" value="Projekt URL" />
                <JetInput id="url" v-model="project.url" type="text" class="mt-1 block w-full"
                    placeholder="https://example.net" />
                <JetInputError :message="project.errors.url" class="mt-2" />
            </div>
            <!-- Logo -->
            <div class="col-span-6 sm:col-span-4">
                <img v-if="project.logo" :src="project.logo" class="w-24 h-24" />
                <JetButton @click="project.logotrigger = true" type="button" class="block button mx-auto mt-2">Logo
                    ändern</JetButton>
                <avatar-cropper @uploaded="uploaded(project)" :upload-url="'/projects/' + project.id + '/logo'"
                    v-model="project.logotrigger" />
            </div>
        </template>

        <template #actions>
            <div class="flex justify-between" :class="{ 'w-full': index }">
                <JetButton v-if="index != 0" type="button" @click="destroy(project)" class="bg-red-500 mr-5">
                    Löschen
                </JetButton>
                <div class="flex items-center">
                    <JetActionMessage :on="project.recentlySuccessful" class="mr-3">
                        Gesichert.
                    </JetActionMessage>
                    <JetButton :class="{ 'opacity-25': project.processing }" :disabled="project.processing">
                        Speichern
                    </JetButton>
                </div>
            </div>
        </template>
    </JetFormSection>
    <div class="flex justify-end mt-6">
        <JetButton @click="new_project()">
            Neues Projekt
        </JetButton>
    </div>
</template>
