<html>

<head>
    <title>Sign Up | Quiz</title>
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
        <p id='main-font'>Create an account</p>
        <p class='faded-font'>Sign Up by entering fields below</p>
        <br>

        <form id="sign-form" method="post">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" placeholder="Enter desired username" required>
            <br>

            <label for="email">Email address:</label>
            <input type="email" name="email" name="email" placeholder="Enter an email address" required>
            <br>

            <label for="password">Enter password:</label>
            <input type="password" name="password" id="password" placeholder="Enter a password" required
                pattern=".{6,}">
            <br>

            <label for="confirmPassword">Confirm Password:</label>
            <input type="password" name="confirmPassword" id="confirmPassword" placeholder="Repeat the password" required
                pattern=".{6,}">
            <br>

            <a class="faded-font" href='http://quiz-game/client/pages/sign_in.php'>Already have one?Log In</a>
            <br>
            <input type="submit" value="Sign Up">
            <div id="status">

            </div>
        </form>
    </div>
    <script type="module" src="../src/js/sign_up.js"></script>


    <footer>
        <div id="footer">
        </div>
    </footer>



</html>