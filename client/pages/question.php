<html>

<head>
    <title>Sign Up</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="http://quiz-game/client/src/css/main_pages.css">
    <link rel="stylesheet" href="http://quiz-game/client/src/css/question.css">
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
    <img src="http://quiz-game/client/assets/images/profile.png" alt="Image">
    <span class="button-text">Profile</span>
  </button>
    </div>

  <div style="flex: 5" id="second-block">
  <div  id="home"style="display:flex">
    <div style="flex:9">
    <p><b>Quiz</b><br>
    <span id="undertext">Answer a question below</span></p>
    </div>
    <div style="flex:1;text-align: left;">
    <p id="timer"><b>Time:sometime</b><p>
    </div>
</div>
  <div id="question_info">
  <div id="quesion_picture" style="flex:1">
  <div>
  <div id="question_text" style="flex:1">
  <p><span style="font-size:20px"><b>Question 2/5</b></span>
    <br>
    <span>Theme: History</span>
      <br>
    <span >Guy Bailey, Roy Hackett and Paul Stephenson made history in 1963, as part of a protest against a bus company that refused to employ black and Asian drivers in which UK city?</span>
  </div>
</div>
</div>
</div>
  <div id="answer_options">
    <p>
      <span style="font-size:17px;"><b>Choose answer</b></span>
      <form>
      <input type="radio" id="option1" name="options" value="1">
      <label for="option1">Option 1</label><br>
      <input type="radio" id="option2" name="options" value="2">
      <label for="option2">Option 2</label><br>
      <input type="radio" id="option3" name="options" value="3">
      <label for="option3">Option 3</label><br>
      <input type="radio" id="option4" name="options" value="4">
      <label for="option4">NOU</label>
      </form>
    </p>
  </div>
  <div id="movement_buttons">
  <button id="previous-button">
    <span class="button-text">Previous</span>
  </button>
  <button id="next-button">
    <span class="button-text">Next</span>
  </button>
  </div>
</div>

<script>
    $("#header").load("widgets/header.html");
</script>
    

</html>