export class User {
    constructor(name, email, password) {
        this.name = name;
        this.email = email;
        this.password = password;
    }

    validateSignUp(confirmPass) {
        if (this.name === '' || this.email === '' || this.password === '') {
            console.log("what!")
            return false;
        } else {
            if (this.password !== confirmPass) {
                console.log("what")
                return false;
            }
        }
        return true;
    }

    validateSignIn() {
        if (this.email === '' || this.password === '') {
            return false;
        }
        return true;
    }

    fromJSON(json) {
        this.name = json.name;
        this.email = json.email;
        this.password = json.password;
    }

    toJSON() {
        return {
            name: this.name,
            email: this.email,
            password: this.password,
        };
    }

    handleSignUp(confirmPass) {
        if (this.validateSignUp(confirmPass)) {
            const jsonData = JSON.stringify(this.toJSON());
            this.handleHttpRequest(jsonData, "sign_up");
        } else {
            this.showError("Please fill in all fields correctly.");
        }
    }

    handleSignIn() {
        if (this.validateSignIn()) {
            const jsonData = JSON.stringify(this.toJSON());
            this.handleHttpRequest(jsonData, "sign_in");
        } else {
            this.showError("Please fill in all fields correctly.");
        }
    }

    render(message) {
        $("#responseText").html(message);
    }

    showError(message) {
        $("#responseText").html("Error: " + message);
    }

    handleHttpRequest(jsonData, url) {
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "../../server/server.php/" + url);
        xhr.setRequestHeader("Content-Type", "application/json");
        xhr.onreadystatechange = () => {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    //console.log(xhr.responseText);
                    let response1 = JSON.parse(xhr.responseText);
                    //console.log(response);
                    console.log(xhr.response);
                    //let response1 = JSON.parse(response);
                    if (response1.id != null) {
                        localStorage.setItem("username", response1.name);
                        localStorage.setItem("ID", response1.id);
                        localStorage.setItem("role", response1.role);
                        localStorage.setItem("email", response1.email);
                    }

                    //this.render(response.message);
                    // Add a 1.5 second delay before redirecting to the index page
                    if (response1.id != null) setTimeout(function () {
                        window.location.href = "../pages/index.php";
                    }, 1500);
                } else {
                    //this.showError(xhr.status);
                }
            }
        };
        xhr.send(jsonData);
    }
}