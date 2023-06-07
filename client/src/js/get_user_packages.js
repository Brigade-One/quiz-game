import {Package} from "http://quiz-game/client/models/package.js"


document.addEventListener('DOMContentLoaded', function (event) {
    event.preventDefault();

    const packages = new Package();

    packages.handleUserHttpRequest("user_packages", localStorage.getItem("ID"));

});