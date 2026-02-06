importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js');

firebase.initializeApp({
    apiKey: "AIzaSyBv2m2kqhIGAKbRqmkE-BMp4Z6s_tQb1no",
    authDomain: "mercado-verde-971b5.firebaseapp.com",
    projectId: "mercado-verde-971b5",
    storageBucket: "mercado-verde-971b5.firebasestorage.app",
    messagingSenderId: "1097619108132",
    appId: "1:1097619108132:web:d489314d3ece4e94b3c3b1",
    measurementId: "G-Y9MXFF4QE1"
});

const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function (payload) {
    return self.registration.showNotification(payload.data.title, {
        body: payload.data.body ? payload.data.body : '',
        icon: payload.data.icon ? payload.data.icon : ''
    });
});