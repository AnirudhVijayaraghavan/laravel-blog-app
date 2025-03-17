import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allow your team to quickly build robust real-time web applications.
 */

import Echo from 'laravel-echo';

import Pusher from 'pusher-js';
window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,

    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,

    forceTLS: true
});
// window.Echo = new Echo({

//     broadcaster: 'pusher',

//     key: import.meta.env.VITE_PUSHER_APP_KEY,

//     cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,

//     forceTLS: true

// });
// var channel = Echo.channel('chatchannel');
// channel.listen('.my-event', function (data) {
//     alert(JSON.stringify(data));
// });
// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: import.meta.env.VITE_PUSHER_APP_KEY,
//     wsHost: import.meta.env.VITE_PUSHER_HOST,
//     wsPort: import.meta.env.VITE_PUSHER_PORT ?? 80,
//     wssPort: import.meta.env.VITE_PUSHER_PORT ?? 443,
//     forceTLS: (import.meta.env.VITE_PUSHER_SCHEME ?? 'https') === 'https',
//     enabledTransports: ['ws', 'wss'],
//     cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER
// });
