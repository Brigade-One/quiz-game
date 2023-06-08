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

    </div>

    <div style="flex: 5;" id="second-block">
      <div id="home">
        <p><b>Create a new package</b>
      </div>
      <div id="package_name">
        <hr>
        <label for="package_name_value" id="package_name_label">Package name</label>
        <br>
        <input type="text" id="package_name_value" placeholder="Enter package name"></input>
      </div>
      <div id="question"><label for="question_text">Add questions</label>
        <div class="question_info">
          <h5 class="question_number">#1</h5>
          <input type="text" class="question_text_value" placeholder="Enter question text" required></input>
          <div style="display:flex">
            <div style="flex:49.5;width:10%;">
              <input type="text" class="answer_value" placeholder="Enter answer" required></input><span> </span><input
                type="text" placeholder="Enter hint" class="hint_value"></input>
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
        <input type=submit id="create-button" value="Create">

        </input>
      </div>
    </div>
  </div>

  <script>
    $("#header").load("widgets/header.html");
    $(document).ready(function () {
      $("#first-block").load("widgets/nav_buttons.html");
    });

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
  <script type="module" src="../src/js/create_package.js"></script>

</html>