<html>

<head>
    <title>Sign Up</title>
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
    <p><b>Home</b></p>
    </div>
    <div  id="options">
    <ul>
        <li class="obligatory_item">
            <button class="listitem">
                <span>Create new package</span>
            </button>
        </li>
        <li class="obligatory_item">
            <button class="listitem">
                <span>Manage my packages</span>
            </button>
        </li>
        <li class="obligatory_item">
        <button class="listitem">
                <span>Start training</span>
            </button>
        </li>
        <li class="obligatory_item">
        <button class="listitem">
                <span>Start competition</span>
            </button>
        </li>
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
    </ul>
    </div>
    
    
</div>
</div>

<script>
    $("#header").load("widgets/header.html");
</script>
    

</html>