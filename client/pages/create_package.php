<html>

<head>
  <title>Create a package | Quiz</title>
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
      <button onclick="window.location.href='http://quiz-game/client/pages/index.php'" id="home-button">
        <img src="http://quiz-game/client/assets/images/home_button_image.jpg" alt="Image">
        <span class="button-text">Home</span>
      </button>
      <button id="profile-button">
        <img src="http://quiz-game/client/assets/images/profile.png" alt="Image">
        <span class="button-text">Profile</span>
      </button>
    </div>

    <div style="flex: 5;" id="second-block">
      <div id="home">
        <p><b>Create a new package</b>
      </div>
      <div id="package_name">
        <hr>
        <label for="package_name_value"  id="package_name_label">Package name</label>
        <br> 
        <input type="text" id="package_name_value" placeholder="Enter package name"></input>
      </div>
      <div id="question"><label for="question_text">Add questions</label>
        <div class="question_info">
          <h5 class="question_number">#1</h5>
          <input type="text" id="question_text_value" placeholder="Enter question text"></input>
          <div style="display:flex">
            <div style="flex:49.5;width:10%;">
              <input type="text" id="answer_value" placeholder="Enter answer"></input><span> </span><input type="text"
                placeholder="Enter hint" id="hint_value"></input>
            </div>
            <div style="flex:50.5;">
            </div>
          </div>
          <hr>
        </div>
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

    // Add a click event listener to the add question button
    $("#new-button").click(function () {
  var clonedQuestionInfo = $(".question_info:first").clone();
  var existingQuestionInfo = $(".question_info");
  var totalQuestions = existingQuestionInfo.length;
  var questionNumber = clonedQuestionInfo.find(".question_number");

  // Clear input values
  clonedQuestionInfo.find("input[type='text']").val("");

  questionNumber.text("#" + (totalQuestions + 1));
  $("#question").append(clonedQuestionInfo);
});



  </script>


</html>