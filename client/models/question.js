export class Question {
    constructor(question, answer, hint) {
        this.question = question;
        this.answer = answer;
        this.hint = hint;
    }

    fromJSON(json) {

        this.question = json.question;
        this.answer = json.answer;
        this.hint = json.hint;
    }

    toJSON() {
        return {
            question: this.question, 
            answer: this.answer,
            hint: this.hint,

        };
    }

    checkAnswer(user_answer){
        if (user_answer != this.answer){
            return false;
        }
        return true;
    }


    handleHttpRequest(jsonData, url) {
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "../../server/server.php/" + url);
        xhr.setRequestHeader("Content-Type", "application/json");
        xhr.onreadystatechange = () => {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);
                    console.log(xhr.response);
                    
                    // Add a 1.5 second delay before redirecting to the index page
                } else {
                    
                }
            }
        };
        xhr.send(jsonData);
    }

    handleGETHttpRequest(jsonData, url, pack_name) {
        const xhr = new XMLHttpRequest();
        xhr.open("GET", "../../server/server.php/" + url+ "?packageID="+jsonData);
        xhr.onreadystatechange = () => {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    console.log(xhr);
                    const response = JSON.parse(xhr.responseText);
                    console.log(response);
                    let counter = 1;
                    try{
                        for (const i of response) {
                            //console.log(i);
                            let result_i = JSON.parse(i);
                            console.log(result_i);
                            localStorage.setItem("question"+counter, result_i.question);
                            localStorage.setItem("answer"+counter, result_i.answer);
                            localStorage.setItem("hint"+counter, result_i.hint);
                            counter = counter + 1;
                        }
                    }catch(error){
                        localStorage.setItem("question"+counter, result_i.question);
                        localStorage.setItem("answer"+counter, result_i.answer);
                        localStorage.setItem("hint"+counter, result_i.hint);
                        counter = counter + 1;
                    }
                    localStorage.setItem("number_of_questions", counter-1);

                    for (let i = 1; i <= counter-2; i++) {
                        var alter_i = i+1;
                        var clonedQuestionInfo = $(".question_info:first").clone();
                        var existingQuestionInfo = $(".question_info");
                        var totalQuestions = existingQuestionInfo.length;
                        var questionNumber = clonedQuestionInfo.find(".question_number");
                        var questionText = clonedQuestionInfo.find(".question_text_value");
                        questionText.attr("id", "text"+alter_i);
                        var questionAns = clonedQuestionInfo.find(".answer_value");
                        questionAns.attr("id", "ans"+alter_i);
                        var questionText = clonedQuestionInfo.find(".hint_value");
                        questionText.attr("id", "hint"+alter_i);
                        // Clear input values
                        clonedQuestionInfo.find("input[type='text']").val("");

                        questionNumber.text("#" + alter_i);
                        $("#question").append(clonedQuestionInfo);
                    }
                    $("#package_name_value").val(pack_name);
                    for (let i = 1; i <= counter-1; i++) {
                        $("#text"+i).val(localStorage.getItem("question"+i));
                        $("#ans"+i).val(localStorage.getItem("answer"+i));
                        $("#hint"+i).val(localStorage.getItem("hint"+i));
                    }
                    //const response = JSON.parse(xhr.responseText);
                    
                    // Add a 1.5 second delay before redirecting to the index page
                }
            }
        };
        xhr.send();
    }
}