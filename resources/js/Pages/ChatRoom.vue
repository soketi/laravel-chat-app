<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Chat room: {{ room }}
            </h2>
            <div>
                Shareable link: <code class="bg-yellow-300 rounded-lg px-2 py-0.5 select-all">{{ link }}</code>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl flex items-start mx-auto sm:px-6 lg:px-8 space-x-2">
                <div class="w-1/4 bg-white shadow-sm sm:rounded-lg p-3 text-sm">
                    <div
                        v-for="user in users"
                        :key="user.id"
                        :class="{
                            'font-bold': $page.props.auth.user.id === user.id,
                        }"
                    >
                        {{ user.name }}
                    </div>
                </div>
                <div class="flex flex-col space-y-3 flex-1 h-96 overflow-y-auto">
                    <div
                        class="bg-white shadow-sm sm:rounded-lg p-3 w-full"
                        v-for="(line, i) in lines"
                        :key="i"
                    >
                        <div :class="{
                            'text-red-500': line.type === 'error',
                            'italic text-gray-600': line.type === 'system',
                        }">
                            <div
                                v-if="line.type === 'message'"
                                class="font-bold"
                            >
                                {{ line.user.name }}
                            </div>
                            <div>
                                {{ line.message }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="bottom-auto p-6 bg-white w-full">
            <breeze-input
                v-model="message"
                type="text"
                class="mt-1 block max-w-7xl w-full mx-auto"
                placeholder="Type your message here and press ENTER..."
                @keyup.enter="sendMessage"
            />
        </div>
    </BreezeAuthenticatedLayout>
</template>

<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue'
import BreezeInput from '@/Components/Input.vue'
import { Head } from '@inertiajs/inertia-vue3';

export default {
    components: {
        BreezeAuthenticatedLayout,
        BreezeInput,
        Head,
    },

    props: [
        'room',
        'link',
    ],

    data() {
        return {
            lines: [],
            users: [],
            message: '',
        };
    },

    mounted() {
        window.Echo
            .join(`room.${this.room}`)
            .here(users => {
                this.users = users;
                this.systemMessage('You have joined the channel.');
            })
            .joining(user => {
                this.users.push(user);
                this.systemMessage(`${user.name} joined the channel.`);
            })
            .leaving(user => {
                this.users.splice(this.users.indexOf(user), 1);
                this.systemMessage(`${user.name} left the channel.`);
            })
            .error((error) => {
                this.errorMessage(`Received error: ${JSON.stringify(error)}`);
            })
            .listen('.room.message', ({ message, user }) => {
                this.userMessage(message, user);
            });
    },

    methods: {
        systemMessage(message) {
            this.lines.push({ message, type: 'system' });
        },

        errorMessage(message) {
            this.lines.push({ message, type: 'error' });
        },

        userMessage(message, user) {
            this.lines.push({ message, user, type: 'message' });
        },

        sendMessage() {
            let message = this.message;
            this.message = '';

            axios.post(this.route('send.message'), { room: this.room, message }).then(() => {
                //
            });
        },
    }
}
</script>
