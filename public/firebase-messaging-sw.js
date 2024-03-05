importScripts('https://www.gstatic.com/firebasejs/10.8.1/firebase-app-compat.js');
importScripts('https://www.gstatic.com/firebasejs/10.8.1/firebase-messaging-compat.js');

const firebaseConfig = {
    apiKey: "AIzaSyCOWcxY-YgZQpld1i4IENI0O1NTmbmAEzM",
    authDomain: "global-escom-it.firebaseapp.com",
    projectId: "global-escom-it",
    storageBucket: "global-escom-it.appspot.com",
    messagingSenderId: "173875494498",
    appId: "1:173875494498:web:3711365a1cbfa2df0d9b3b"
};

firebase.initializeApp(firebaseConfig);

const messaging = firebase.messaging();

messaging.onBackgroundMessage(function (payload) {
    const notificationTitle = payload.notification.title;
    const notificationOptions = {
      body: payload.notification.body
    };

    self.registration.showNotification(notificationTitle, notificationOptions);
});
