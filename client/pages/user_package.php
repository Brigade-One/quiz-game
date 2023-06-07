<html>

<head>
    <title>Sign Up</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="http://quiz-game/client/src/css/main_pages.css">
    <link rel="stylesheet" href="http://quiz-game/client/src/css/package_select.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@700&display=swap');
    </style>

</head>

<body>


    <header>
        <div id="header"></div>
    </header>

    <div style="display: flex;">
        <div style="flex: 1;" id="first-block">

        </div>

        <div style="flex: 5;" id="second-block">
            <div id="home">
                <p><b>Select Package</b><br>
                    <span id="undertext">Training packages</span>
                </p>
            </div>
            <div id="package_list">
                <table id="package_table">
                    <tr>
                        <th>#</th>
                        <th>name</th>
                        <th>Question amount</th>
                    </tr>

                    


                </table>
            </div>

            <button onclick="receiveUserPackages()">Dummy</button>

        </div>
    </div>


    <script>
        $("#header").load("widgets/header.html");
        $(document).ready(function () {
            $("#first-block").load("widgets/nav_buttons.html");
        });
        function receiveUserPackages() {
            //TODO: send package ID to server and receive package questions
            const xhr = new XMLHttpRequest();
            xhr.open('GET', 'http://quiz-game/server/server.php/user_packages?userID=6f5aa13c-4de4-4ebc-916a-766fc8928bad');
            xhr.send();
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    console.log(xhr);
                    const response = xhr.response;
                    const packages = JSON.parse(response);
                    packages.forEach(function (package){
                        console.log(package);
                    })
                }
            }
        }
    </script>
    <script type="module" src="../src/js/get_user_packages.js"></script>

</html>