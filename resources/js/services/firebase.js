import {
    initializeApp
} from 'firebase/app'
import {
    getMessaging,
    getToken,
    onMessage
} from 'firebase/messaging'

var firebaseConfig = {
    apiKey: "AIzaSyCOWcxY-YgZQpld1i4IENI0O1NTmbmAEzM",
    authDomain: "global-escom-it.firebaseapp.com",
    projectId: "global-escom-it",
    storageBucket: "global-escom-it.appspot.com",
    messagingSenderId: "173875494498",
    appId: "1:173875494498:web:3711365a1cbfa2df0d9b3b"
};

const app = initializeApp(firebaseConfig)
const messaging = getMessaging(app)

export const fetchToken = async () => {
    return await getToken(messaging, {
        vapidKey: 'BIRxJuf8Byj0ESBHie6eMbMccfIonZa6pkss6VwnNpq0cGiA-BZk3wrYsuHrn6Is_hxgm2w2ALMspAcJsIi6xUQ'
    })
}

export const onMessageListener = () =>
    new Promise((resolve) => {
        onMessage(messaging, (payload) => {
            resolve(payload);
        });
    });
