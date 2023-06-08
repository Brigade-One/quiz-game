<html>

<head>
    <title>Competition 1x1 | Quiz</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="http://quiz-game/client/src/css/main_pages.css">
    <link rel="stylesheet" href="http://quiz-game/client/src/css/create.css">
    <link rel="stylesheet" href="http://quiz-game/client/src/css/competition.css">
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

            <button id="search-button">
                Search Opponent
            </button>

            <div id="loading-animation" style="display: none;">
                <img src="http://quiz-game/client/assets/images/loading.gif" alt="Loading..." id="loading-gif">
                <p id="loading-text">Searching opponent...</p>
            </div>

        </div>
    </div>



    <script>
        $("#header").load("widgets/header.html");
        $(document).ready(function () {
            $("#first-block").load("widgets/nav_buttons.html");
        });
        $("#search-button").click(function () {
            $("#loading-animation").show();

            sendUserToPool();
        });
        function sendUserToPool() {
            // Make AJAX request to search for an opponent
            $.ajax({
                url: "http://quiz-game/server/server.php/user_pool?userID=" + localStorage.getItem("ID"),
                timeout: 2000,
                type: "POST",
                success: function (data) {
                    if (data === "") {
                        setTimeout(sendUserToPool, 2000);
                        return;
                    }
                    let opponentID = JSON.parse(data).opponentID;

                    if (opponentID) {
                        window.location.href = "http://quiz-game/client/pages/competition.php?opponentID=" + opponentID;
                    }
                    else {
                        setTimeout(sendUserToPool, 2000);
                    }
                    setTimeout(sendUserToPool, 2000);
                },
                error: function () {
                    // Handle error scenarios
                    setTimeout(sendUserToPool, 2000);
                }
            });
        };
        let opponentID;

        <?php
        $opponentID = isset($_GET["opponentID"]) ? $_GET["opponentID"] : "";
        ?>
        if (opponentID) {
            $("#loading-animation").hide();
            $("#second-block").append("<p>Opponent found!</p>");
            $("#second-block").append("<button id='start-button'>Start</button>");
            $("#start-button").click(function () {
                window.location.href = "http://quiz-game/client/pages/competition.php?opponentID=" + opponentID;
            });
        }
    </script>


</html>