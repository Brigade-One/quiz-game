import {Package} from "http://quiz-game/client/models/package.js"


document.addEventListener('DOMContentLoaded', function (event) {
    event.preventDefault();

    const packages = new Package();

    packages.handleUserManagementHttpRequest("user_packages", localStorage.getItem("ID"));

});