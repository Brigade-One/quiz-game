<html>

<head>
    <title>Sign Up</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="http://quiz-game/client/src/css/main_pages.css">
    <link rel="stylesheet" href="http://quiz-game/client/src/css/create.css">
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
    </div>

  <div style="flex: 5;" id="second-block">
  <div  id="home">
    <p><b>Create a new package</b>
    </div>
    <div id="package_name">
    <hr>
        <label for="package_name_value">Package name</label>
        <br>
        <input type="text" id="package_name_value"></input>
    </div>
    <div id="question">
        <label for="question_text">Package name</label>
        <br>
        <input type="text" id="question_text_value"></input> 
        <div style="display:flex">
        <div style="flex:49.5;width:10%;">
        <input type="text"id="answer_value"></input><span>          </span><input type="text" id="hint_value"></input>
        </div>
        <div style="flex:50.5;">
        </div>
        </div>
        <hr>
  </div>
  <button id="new-button">
    
    <span class="button-text">+ Add a question</span>
  </button>
    <div id="creation">
    <button id="create-button">
    
    <span class="button-text">Create</span>
  </button>
    </div>
</div>
</div>

<script>
    $("#header").load("widgets/header.html");
</script>
    

</html>