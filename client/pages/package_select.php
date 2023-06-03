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
  <button id="home-button">
    <img src="http://quiz-game/client/assets/images/home_button_image.jpg" alt="Image">
    <span class="button-text">Home</span>
  </button>
  <button id="profile-button">
    <img src="http://quiz-game/client/assets/images/profile_2.jpg" alt="Image">
    <span class="button-text">Profile</span>
  </button>
  <button id="logout-button">
    <img src="http://quiz-game/client/assets/images/logout.jpg" alt="Image">
    <span class="button-text">Log Out</span>
  </button>
    </div>

  <div style="flex: 5;" id="second-block">
    <div  id="home">
    <p><b>Select Package</b><br>
    <span id="undertext">Training packages</span></p>
    </div>
    <br>
    <br>
    <div id="package_list">
    <table id="package_table">
        <tr>
            <th>#</th>
            <th>name</th>
            <th>Question amount</th>
        </tr>

        <tr class="ordinary_row">
            <td>1</td>
            <td>PackageName</td>
            <td>20 Question </td>
            <td><button class="select_button" onclick="window.location.href='https://www.example.com'">Select</button></td>
        </tr>
        <tr class="ordinary_row">
            <td>2</td>
            <td>PackageName</td>
            <td>20 Question </td>
            <td><button class="select_button" onclick="window.location.href='https://www.example.com'">Select</button></td>
        </tr>
        <tr class="ordinary_row">
            <td>3</td>
            <td>PackageName</td>
            <td>20 Question </td>
            <td><button class="select_button" onclick="window.location.href='https://www.example.com'">Select</button></td>
        </tr>

    </table>
    </div>
    
    
    
</div>
</div>

<script>
    $("#header").load("widgets/header.html");
</script>
    

</html>