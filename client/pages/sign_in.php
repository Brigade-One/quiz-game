<html>

<head>
    <title>Log In | Quiz</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="http://quiz-game/client/src/css/sign_pages.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@700&display=swap');
    </style>
</head>

<body>
    <header>
        <div id="header"></div>
    </header>
    <div id="container-block">
        <p id='main-font'>Log In to your Account</p>
        <p class='faded-font'>with your registered Email Address</p>
        <br>


        <form id="sign-form" method="post">

            <label for="email">Email Address:</label>
            <input type="email" name="email" name="email" placeholder="Enter your email address" required>
            <br>

            <label for="password">Enter password:</label>
            <input type="password" name="password" id="password" placeholder="Enter your password" required
                pattern=".{6,}">
            <br>

            <a class="faded-font" href='http://quiz-game/client/pages/sign_up.php'>Don't have an account yet? Sign Up</a>
            <br>
            <input type="submit" value="Login">
            <div id="status">

            </div>
        </form>
    </div>
    <script type="module" src="../src/js/sign_in.js"></script>


    <footer>
        <div id="footer">
        </div>
    </footer>



</html>