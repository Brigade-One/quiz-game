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
                console.log("Done");
                console.log(xhr);
                if (xhr.status === 200) {
                   console.dir(xhr);
                    
                    // Add a 1.5 second delay before redirecting to the index page
                } else {
                    
                }
            }
        };
        xhr.send();
    }
}