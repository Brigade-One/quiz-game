import {Question} from "http://quiz-game/client/models/question.js"


document.addEventListener('DOMContentLoaded', function (event) {
    event.preventDefault();
    console.log("ha");
    console.log(PackageID);

    let get_questions_handle = new Question;
    get_questions_handle.handleGETHttpRequest(PackageID, "question")

});