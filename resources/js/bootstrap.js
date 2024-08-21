import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// import Echo from 'laravel-echo';
// import io from 'socket.io-client';

// window.Echo = new Echo({
//     broadcaster: 'socket.io',
//     client: io,
//     host: window.location.hostname + ':3000', // URL server Socket.IO
// });

// window.Echo.channel('user.' + userId)
//     .listen('RefreshPage', (event) => {
//         window.location.reload();
//     });
