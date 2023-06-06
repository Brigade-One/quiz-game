import {User} from "http://quiz-game/client/models/user.js"


const form = document.querySelector('#sign-form');
form.addEventListener('submit', function (event) {
    event.preventDefault();

    // Get the form data
    const formData = new FormData(form);
    const user = new User(formData.get('name'), formData.get('email'), formData.get('password'));
    

    user.handleSignUp(formData.get("confirmPassword"));

});