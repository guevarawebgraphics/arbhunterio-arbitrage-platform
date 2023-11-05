const Echo = require('laravel-echo').default;
console.log('Echo:', Echo);

window.Pusher = require('pusher-js');
console.log('Pusher:', window.Pusher);

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: 'dev', // change to `dev` if local or non-https. Else if production make it `app`
    cluster: 'mt1',
    wsHost: window.location.hostname,
    wsPort: 6001,
    wssPort: 6001,
    forceTLS: false,
    encrypted: true,
    enabledTransports: ['ws','wss'],
    authEndpoint: 'broadcasting/auth',
});  