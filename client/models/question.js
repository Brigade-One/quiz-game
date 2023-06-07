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
                    
                    // Add a 1.5 second delay before redirecting to the index page
                } else {
                    
                }
            }
        };
        xhr.send(jsonData);
    }

    handleGETHttpRequest(jsonData, url) {
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
                    //const response = JSON.parse(xhr.responseText);
                    
                    // Add a 1.5 second delay before redirecting to the index page
                } else {
                    
                }
            }
        };
        xhr.send();
    }
}