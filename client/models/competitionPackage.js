export class CompetitionPackage {
    constructor(name) {
        this.name = name;
    }

    fromJSON(json) {
        this.name = json.name;
    }

    toJSON() {
        return {
            name: this.name,

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
                    console.log(xhr.response);
                    
                } else {
                    
                }
            }
        };
        xhr.send(jsonData);
    }
}