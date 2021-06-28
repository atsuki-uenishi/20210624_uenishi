import firebase from 'firebase'

if(!firebase.apps.length) {
    firebase.initializeApp(
        {
            apiKey: "AIzaSyDVOYZ8tVwZm9U-XcJC3vIyo-6glpArgxE",
            authDomain: "sns-practice-5e941.firebaseapp.com",
            projectId: "sns-practice-5e941",
            storageBucket: "sns-practice-5e941.appspot.com",
            messagingSenderId: "280295040786",
            appId: "1:280295040786:web:350f63cb9cd4c17c4675cb",
            measurementId: "G-HX6VHK763V"
        }
    )
    firebase.auth().setPersistence(firebase.auth.Auth.Persistence.SESSION).then(() => {
        console.log('Initialized')
    })
}

export default firebase