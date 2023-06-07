export class Package {
    constructor(name, isApproved = false) {
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
                    let result = JSON.parse(xhr.response);
                    try{
                        for (const i of result) {
                            console.log(i);
                            $("#package_table").html($("#package_table").html() + '<tr class="ordinary_row"><td>1</td><td>' + i.name + '</td><td>20 Question </td><td><a class="select_button" href = "http://quiz-game/client/pages/question.php?packageID=' + i.packageID + '">Select</a></td></tr>');
                        }
                    }catch(error){
                        $("#package_table").html($("#package_table").html() + '<tr class="ordinary_row"><td>1</td><td>' + result.name + '</td><td>20 Question </td><td><a class="select_button" href = "http://quiz-game/client/pages/question.php?packageID=' + result.packageID + '">Select</a></td></tr>')
                    }
                    // Add a 1.5 second delay before redirecting to the index page
                } else {

                }
            }
        };
        xhr.send();
    }

    handleUserHttpRequest(url, userID) {
        const xhr = new XMLHttpRequest();
        //xhr.open("GET", "../../server/server.php/" + url+"?userID="+userID);
        console.log('Test user id');
        xhr.open("GET", "../../server/server.php/" + url+"?userID=6f5aa13c-4de4-4ebc-916a-766fc8928bad");
        //xhr.open('GET', 'http://quiz-game/server/server.php/user_packages?userID=6f5aa13c-4de4-4ebc-916a-766fc8928bad');
        xhr.onreadystatechange = () => {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    const response = xhr.response;
                    const packages = JSON.parse(response);
                    packages.forEach(function (packager){
                        console.log(packager);
                        let decoded_packager = JSON.parse(packager);
                        console.log(decoded_packager);
                        $("#package_table").html($("#package_table").html() + '<tr class="ordinary_row"><td>1</td><td>' + decoded_packager.name + '</td><td>20 Question </td><td><a class="select_button" href = "http://quiz-game/client/pages/question.php?packageID=' + decoded_packager.packageID + '">Select</a></td></tr>');
                    })
                    
                    // Add a 1.5 second delay before redirecting to the index page
                } else {

                }
            }
        };
        xhr.send();
    }


    sendQuestionHandleHttpRequest1(url, question) {
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
        //xhr.send("question_text="+question.question+"&question_answer"+question.answer+"&question_hint"+question.hint);
        xhr.send(question);
    }

    sendQuestionHandleHttpRequest(url, json_list) {
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

        console.log(json_list);
        xhr.send("name=" + json_list);
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

        xhr.send("package_name=" + package_name);
    }
}