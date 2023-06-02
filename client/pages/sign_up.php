<html>

<head>
    <title>Sign Up</title>
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
    <p id='main-font'>Register your Account</p>
    <br>

    <form id="sign-form" method="post">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username"  required>
        <br>

        <label for="email">Email address:</label>
        <input type="email" name="email" name="email"  required>
        <br>

        <label for="password">Enter password:</label>
        <input type="password" name="password" id="password"
            required pattern=".{6,}">
        <br>

        <label for="confirmPassword">Confirm Password:</label>
        <input type="password" name="confirmPassword" id="confirmPassword"  required>
        <br>

        <a class="faded-font" href='http://quiz-game/client/pages/sign_in.php'>Already have one?</a>
        <br>
        <input type="submit" value="Register">
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