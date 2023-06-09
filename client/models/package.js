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
                    console.log(xhr.response);
                    //let result = JSON.parse(preresult);
                    try {
                        for (const i of result) {
                            //console.log(i);
                            let result_i = JSON.parse(i);
                            $("#package_table").html($("#package_table").html() + '<tr class="ordinary_row"><td class="first_element">1</td><td class="second_element">' + result_i.name + '</td><td>20 Question </td><td><a class="select_button" href = "http://quiz-game/client/pages/question.php?packageID=' + result_i.packageID + "&questionNumber=1" + '">Select</a></td></tr>');
                        }
                    } catch (error) {
                        $("#package_table").html($("#package_table").html() + '<tr class="ordinary_row"><td class="first_element">1</td><td class="second_element">' + result.name + '</td><td >20 Question </td><td><a class="select_button" href = "http://quiz-game/client/pages/question.php?packageID=' + result.packageID + "&questionNumber=1" + '">Select</a></td></tr>')
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
        xhr.open("GET", "../../server/server.php/" + url + "?userID=" + userID);
        //console.log('Test user id');
        //xhr.open("GET", "../../server/server.php/" + url+"?userID=6f5aa13c-4de4-4ebc-916a-766fc8928bad");
        //xhr.open('GET', 'http://quiz-game/server/server.php/user_packages?userID=6f5aa13c-4de4-4ebc-916a-766fc8928bad');
        xhr.onreadystatechange = () => {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    const response = xhr.response;
                    const packages = JSON.parse(response);
                    console.log(xhr.response);
                    packages.forEach(function (packager) {
                        console.log(packager);
                        let decoded_packager = JSON.parse(packager);
                        console.log(decoded_packager);
                        $("#package_table").html($("#package_table").html() + '<tr class="ordinary_row"><td class="first_element">1</td><td class="second_element">' + decoded_packager.name + '</td><td>20 Question </td><td ><a class="select_button" href = "http://quiz-game/client/pages/question.php?packageID=' + decoded_packager.packageID + '">Select</a></td></tr>');
                    })
                    // Add a 1.5 second delay before redirecting to the index page
                } else {

                }
            }
        };
        xhr.send();
    }
    handleGetPackagesHttpRequest(url, userID) {
        const xhr = new XMLHttpRequest();
        xhr.open("GET", "../../server/server.php/" + url + "?userID=" + userID);
        //console.log('Test user id');
        //xhr.open("GET", "../../server/server.php/" + url+"?userID=6f5aa13c-4de4-4ebc-916a-766fc8928bad");
        //xhr.open('GET', 'http://quiz-game/server/server.php/user_packages?userID=6f5aa13c-4de4-4ebc-916a-766fc8928bad');
        xhr.onreadystatechange = () => {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    const response = xhr.response;
                    const packages = JSON.parse(response);
                    console.log(xhr.response);
                    packages.forEach(function (packager) {
                        console.log(packager);
                        let decoded_packager = JSON.parse(packager);
                        localStorage.setItem(decoded_packager.name, decoded_packager.packageID);
                        console.log(decoded_packager);
                        $("#package_table").html($("#package_table").html() + '<tr class="ordinary_row"><td>1</td><td>' + decoded_packager.name + '</td><td>20 Question </td><td><a class="select_button" href="http://quiz-game/client/pages/question.php?packageID=' + decoded_packager.packageID + '&questionNumber=1">Select</a></td></tr>');
                    });
                    // Add a 1.5 second delay before redirecting to the index page
                } else {
                }
            }
        };
        xhr.send();
    }

    handleGetPackagesHttpRequestforPublic(url, userID) {
        const xhr = new XMLHttpRequest();
        xhr.open("GET", "../../server/server.php/" + url + "?userID=" + userID);
        //console.log('Test user id');
        //xhr.open("GET", "../../server/server.php/" + url+"?userID=6f5aa13c-4de4-4ebc-916a-766fc8928bad");
        //xhr.open('GET', 'http://quiz-game/server/server.php/user_packages?userID=6f5aa13c-4de4-4ebc-916a-766fc8928bad');
        xhr.onreadystatechange = () => {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    const response = xhr.response;
                    const packages = JSON.parse(response);
                    console.log(xhr.response);
                    packages.forEach(function (packager) {
                        console.log(packager);
                        let decoded_packager = JSON.parse(packager);
                        localStorage.setItem(decoded_packager.name, decoded_packager.packageID);
                        console.log(decoded_packager);
                        $("#user_package_table").html($("#user_package_table").html() + '<tr class="ordinary_row"><td class="first_element">1</td><td class="second_element">' + decoded_packager.name + '</td><td>20 Question </td><td><a class="select_button" href="http://quiz-game/client/pages/question.php?packageID=' + decoded_packager.packageID + '&questionNumber=1">Select</a></td></tr>');
                    });
                    // Add a 1.5 second delay before redirecting to the index page
                } else {
                }
            }
        };
        xhr.send();
    }

    handleUserManagementHttpRequest(url, userID) {
        const xhr = new XMLHttpRequest();
        xhr.open("GET", "../../server/server.php/" + url + "?userID=" + userID);
        //console.log('Test user id');
        //xhr.open("GET", "../../server/server.php/" + url+"?userID=6f5aa13c-4de4-4ebc-916a-766fc8928bad");
        //xhr.open('GET', 'http://quiz-game/server/server.php/user_packages?userID=6f5aa13c-4de4-4ebc-916a-766fc8928bad');
        xhr.onreadystatechange = () => {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    const response = xhr.response;
                    const packages = JSON.parse(response);
                    console.log(xhr.response);
                    packages.forEach(function (packager) {
                        console.log(packager);
                        let decoded_packager = JSON.parse(packager);
                        localStorage.setItem(decoded_packager.name, decoded_packager.packageID);
                        console.log(decoded_packager);
                        $("#package_table").html($("#package_table").html() + '<tr class="ordinary_row"><td>1</td><td>' + decoded_packager.name + '</td><td>20 Question </td><td><a class="select_button" href = "http://quiz-game/client/pages/manage.php?packageID=' + decoded_packager.packageID + "&pack_name=" + decoded_packager.name + '">Select</a></td></tr>');
                    })

                    // Add a 1.5 second delay before redirecting to the index page
                } else {

                }
            }
        };
        xhr.send();
    }


    sendPackageCreateHandleHttpRequest(url, jsonData) {
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "../../server/server.php/" + url);
        xhr.setRequestHeader("Content-Type", "application/json");
        xhr.onreadystatechange = () => {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    console.dir(xhr);

                    // Add a 1.5 second delay before redirecting to the index page
                } else {

                }
            }
        };

        console.log(jsonData);
        //xhr.send("question_text="+question.question+"&question_answer"+question.answer+"&question_hint"+question.hint);
        xhr.send(JSON.stringify(jsonData));
    }
    sendPackageUpdateHandleHttpRequest(url, jsonData) {
        const xhr = new XMLHttpRequest();
        xhr.open("PUT", "../../server/server.php/" + url);
        xhr.setRequestHeader("Content-Type", "application/json");
        xhr.onreadystatechange = () => {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    console.dir(xhr);
                } else {

                }
            }
        };
        console.log(jsonData);
        xhr.send(JSON.stringify(jsonData));
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