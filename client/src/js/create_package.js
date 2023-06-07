import {Package} from "http://quiz-game/client/models/package.js"
import {Question} from "http://quiz-game/client/models/question.js"

function PackagetoJSON(package_name, question_list){
    return {
        userID: localStorage.getItem("ID"),
        packageName: package_name,
        questions:question_list,
    };
};

$("#create-button").click(function (event) {
    event.preventDefault();
    var package_name = document.getElementById("package_name_value").value;
    //console.dir(elements);
    const packages = new Package();

    var text_elements = document.querySelectorAll('.question_text_value');
    var answer_elements = document.querySelectorAll('.answer_value');
    var hint_elements = document.querySelectorAll('.hint_value');
    
    let question_list = [];

    for (var i = 0; i < text_elements.length; i++) {
    let question = new Question(text_elements[i].value, answer_elements[i].value, hint_elements[i].value);
    question_list[i] = question.toJSON();
    // do something with value
    //packages.sendQuestionHandleHttpRequest("question", question.toJSON());
    }
    //console.log(PackagetoJSON(package_name, question_list));
    packages.sendPackageCreateHandleHttpRequest("create_package", PackagetoJSON(package_name, question_list));
    //packages.sendQuestionHandleHttpRequest("question", question_list);
    //packages.sendPackageNameHandleHttpRequest("package", package_name);
    //packages.createPackageHandleHttpRequest("create_package", package_name, JSON.stringify(question_list));

});

