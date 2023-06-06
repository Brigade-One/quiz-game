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


    createPackageHandleHttpRequest(url, package_name, question_list) {
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
        console.log(package_name);
        console.log(question_list);
        xhr.send("package_name="+package_name+"&question_list="+question_list);
    }

}