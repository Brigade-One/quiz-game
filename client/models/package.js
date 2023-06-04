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
}