export class Package {
    constructor(name, isApproved=false) {
        this.name = name;
        this.isApproved = isApproved;
    }

    fromJSON(json) {
        this.name = json.name;
        this.isApproved = json.isApproved;
    }

    toJSON() {
        return {
            name: this.name,
            isApproved: this.isApproved,
        };
    }



    handleHttpRequest(url) {
        const xhr = new XMLHttpRequest();
        xhr.open("GET", "../../server/server.php/" + url);
        xhr.onreadystatechange = () => {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                   console.dir(xhr);
                    
                    // Add a 1.5 second delay before redirecting to the index page
                } else {
                    
                }
            }
        };
        xhr.send();
    }


    sendQuestionHandleHttpRequest(url, question) {
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "../../server/server.php/" + url);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = () => {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                   console.dir(xhr);
                    
                    // Add a 1.5 second delay before redirecting to the index page
                } else {
                    
                }
            }
        };

        console.log(question);
        xhr.send("question_text="+question.question+"&question_answer"+question.answer+"&question_hint"+question.hint);
    }

    sendPackageNameHandleHttpRequest(url, package_name) {
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "../../server/server.php/" + url);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = () => {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                   console.dir(xhr);
                    
                    // Add a 1.5 second delay before redirecting to the index page
                } else {
                    
                }
            }
        };
        console.log(package_name);

        xhr.send("package_name="+package_name);
    }
}