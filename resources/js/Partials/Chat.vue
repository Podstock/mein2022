<script setup>
import { ref, onUpdated, onMounted } from 'vue';

const compose = ref('');
const chats = ref([]);

function postMessage() {
    if (compose.value.length == 0)
        return;
    axios.post('/chats', {message: compose.value}).then(({data}) => {
        compose.value = '';
    });
};

onUpdated(() => {
    let chat = document.querySelector("#chat");
    chat.scrollTop = chat.scrollHeight;
    window.onresize = function (event) {
        chat.scrollTop = chat.scrollHeight;
    };
});

onMounted(() => {
    axios.get('/chats').then((response) =>{
        chats.value = response.data
    });

    Echo.channel('chat').listen('ChatSent', ({chat}) => {
        chats.value.data.push(chat);
    });
});

</script>

<template>
    <section aria-labelledby="chat-title">
        <div class="bg-white shadow sm:rounded-lg sm:overflow-hidden">
            <div class="divide-y divide-gray-200">
                <div class="px-4 py-2 sm:px-6">
                    <h2 id="chat-title" class="text-lg font-medium text-gray-900">Chat</h2>
                </div>
                <div id="chat" class="px-4 py-6 sm:px-6 overflow-y-scroll max-h-[40vh]">
                    <ul role="list" class="space-y-4">
                        <li v-for="chat in chats.data">
                            <div class="flex space-x-3">
                                <div class="flex-shrink-0">
                                    <img class="h-10 w-10 rounded-full"
                                    :src="chat.avatar"
                                        alt="">
                                </div>
                                <div>
                                    <div class="text-sm space-x-2">
                                        <a href="#" class="font-medium text-gray-900">{{chat.name}}</a>
                                        <span class="text-gray-500 font-medium">{{chat.created}}</span>
                                    </div>
                                    <div v-html="chat.content" class="mt-1 text-sm text-gray-700">
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-6 sm:px-6">
                <div class="flex space-x-3">
                    <div class="flex-shrink-0">
                        <img :src="$page.props.user.avatar_tiny" class="h-10 w-10 rounded-full" alt="">
                    </div>
                    <div class="min-w-0 flex-1">
                            <div>
                                <label for="comment" class="sr-only">About</label>
                                <input v-on:keyup.enter="postMessage" v-model="compose" id="comment" name="comment"
                                    class="shadow-sm block w-full h-8 p-5 focus:ring-lime-600 focus:border-lime-600 sm:text-sm border border-gray-300 rounded-md"
                                    placeholder="Nachricht" />
                            </div>
                            <div class="mt-3 flex items-center justify-between">
                                <a href="#"
                                    class="group inline-flex items-start text-sm space-x-2 text-gray-500 hover:text-gray-900">
                                    <!-- Heroicon name: solid/question-mark-circle -->
                                    <svg class="flex-shrink-0 h-5 w-5 text-gray-400 group-hover:text-gray-500"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                        aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <span>You can use markdown</span>
                                </a>
                                <button @click="postMessage" :disabled="!compose.length" type="submit"
                                    :class="compose.length ? 'bg-lime-700' : 'bg-gray-500'"
                                    class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white hover:bg-lime-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-lime-500">Comment</button>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
