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

            <!-- Модальное окно -->
            <div id="modal" class="modal">
                <div class="modal-content">
                    <p id="packet_answers_result"></p>
                    <span class="close-button">Ясно</span>
                </div>
            </div>

        </div>

    </div>


    <script>
        $("#header").load("widgets/header.html");
        $(document).ready(function () {
            $("#first-block").load("widgets/nav_buttons.html");
        });

        let right_answers = 0;

        if (localStorage.getItem("user_answer1") != null) {
            for (let i = 0; i < localStorage.getItem("number_of_questions"); i++) {
                if (localStorage.getItem("user_answer" + (i + 1)) == localStorage.getItem("answer" + (i + 1))) {
                    right_answers += 1;
                }
            }
        }

        var modal = document.getElementById("modal");
        var btn = document.getElementById("open-modal");
        var span = document.getElementsByClassName("close-button")[0];

        // Открываем модальное окно при нажатии на кнопку
        document.addEventListener('DOMContentLoaded', function (event) {
            event.preventDefault();
            if (localStorage.getItem("user_answer1") != null) {
                modal.style.display = "block";
            }
        })

        // Закрываем модальное окно при нажатии на крестик
        span.onclick = function () {
            modal.style.display = "none";
            result_ID = localStorage.getItem("ID");
            result_role = localStorage.getItem("role");
            result_email = localStorage.getItem("email");
            result_username = localStorage.getItem("username");
            localStorage.clear();
            localStorage.setItem("ID", result_ID);
            localStorage.setItem("role", result_role);
            localStorage.setItem("email", result_email);
            localStorage.setItem("username", result_username);
        }

        // Закрываем модальное окно при нажатии вне его области
        window.onclick = function (event) {
            if (event.target == modal) {
                modal.style.display = "none";
                result_ID = localStorage.getItem("ID");
                result_role = localStorage.getItem("role");
                result_email = localStorage.getItem("email");
                result_username = localStorage.getItem("username");
                localStorage.clear();
                localStorage.setItem("ID", result_ID);
                localStorage.setItem("role", result_role);
                localStorage.setItem("email", result_email);
                localStorage.setItem("username", result_username);
            }
        }

        console.log(right_answers);
        $("#packet_answers_result").html(right_answers + "/" + (localStorage.getItem("number_of_questions")) + " answered right.")
        localStorage.setItem("ratio", (right_answers) / (localStorage.getItem("number_of_questions")));
        localStorage.setItem("right_answers", right_answers);
    </script>
    <script type="module" src="../src/js/get_public_packages.js"></script>
    <script type="module" src="../src/js/get_user_packages_2.js"></script>

</html>