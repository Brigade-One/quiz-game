<html>

<head>
    <title>Home | Quiz</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="http://quiz-game/client/src/css/main_pages.css">
    <link rel="stylesheet" href="http://quiz-game/client/src/css/home_page.css">
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
                <p><b>Home</b></p>
            </div>
            <div id="greeting_block">
                <p id="greeting">Welcome to Quiz! Select option below</p>
            </div>
            <div id="options">
                <ul>
                    <hr>
                    <div class="user">
                        <li class="not_obligatory_item2">
                            <button onclick="window.location.href='http://quiz-game/client/pages/create_package.php'"
                                class="listitem">
                                <span>Create new package</span>
                            </button>
                        </li>
                        <li class="not_obligatory_item2">
                            <button onclick="window.location.href='http://quiz-game/client/pages/user_package.php'"
                                class="listitem">
                                <span>Manage my packages</span>
                            </button>
                        </li>
                        <hr>
                    </div>
                    <li class="obligatory_item">
                        <button class="listitem" id="train_button"
                            onclick="window.location.href='http://quiz-game/client/pages/package_select.php'">
                            <span>Start training</span>
                        </button>
                    </li>
                    <hr>
                    <div class="examiner">
                        <p id="greeting">Examiner block</p>
                        <li class="not_obligatory_item">
                            <button class="listitem">
                                <span>Manage training packages</span>
                            </button>
                        </li>
                        <li class="not_obligatory_item">
                            <button class="listitem">
                                <span>Add competition package</span>
                            </button>
                        </li>
                        <li class="not_obligatory_item">
                            <button class="listitem">
                                <span>Manage competition package</span>
                            </button>
                        </li>
                        <hr>
                    </div>


                </ul>
            </div>


        </div>
    </div>

    <script>
        $("#header").load("widgets/header.html");
        $(document).ready(function () {
            $("#first-block").load("widgets/nav_buttons.html");
        });

        const UserRole = {
            USER: 0,
            EXAMINER: 1,
            GUEST: 2
        };

        var userRole = localStorage.getItem("role");
        $(".examiner").hide();
        $(".user").hide();
        if (userRole == UserRole.EXAMINER) {
            $(".examiner").show();
            $(".user").show();
        } else if (userRole == UserRole.USER) {
            $(".user").show();
        }  
    </script>


</html>