<html>

<head>
  <title>Training | Quiz</title>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link rel="stylesheet" href="http://quiz-game/client/src/css/main_pages.css">
  <link rel="stylesheet" href="http://quiz-game/client/src/css/question.css">
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@700&display=swap');
  </style>
  <script type="module" src="http://quiz-game/client/src/js/timer.js"></script>
  <script>
    const PackageID = <?php echo json_encode($_GET["packageID"]); ?>;
    const questionNumber = <?php echo json_encode($_GET["questionNumber"]); ?>;
    questionText = localStorage.getItem("question" + questionNumber);
    answerText = localStorage.getItem("answer" + questionNumber);
    hintText = localStorage.getItem("hint" + questionNumber);
    const questionCount = localStorage.getItem("number_of_questions");
  </script>
</head>

<body>


  <header>
    <div id="header"></div>
  </header>

  <div style="display: flex;">
    <div style="flex: 1;" id="first-block">

    </div>

    <div style="flex: 5" id="second-block">
      <div id="home" style="display:flex">
        <div style="flex:9">
          <p><b>Quiz</b><br>
            <span id="undertext">Answer a question below</span>
          </p>
        </div>
        <div style="flex:3;text-align: left;">
          <b>
            <p id="timer">
            <p>
          </b>
        </div>
      </div>
      <div id="question_info">
        <div id="quesion_picture" style="flex:1">
          <div>
            <div id="question_text" style="flex:1">
              <p><span style="font-size:20px"><b>Question
                    <?php echo $_GET['questionNumber']; ?>
                  </b></span>
                </b></span>
                <br>
                <span id="themes"> </span>
                <br>
                <span id="question-text"></span>
            </div>
          </div>
        </div>
      </div>
      <div id="answer_options">
        <p>
          <span style="font-size:17px;"><b>Type answer</b></span>
        <form>
          <input type="text" name="answer" id="answer">
        </form>
        </p>
      </div>
      <div id="movement_buttons">
        <button id="previous-button">
          <span class="button-text" onclick="previous_question()">Previous</span>
        </button>
        <button id="next-button">
          <span class="button-text" onclick="next_question()">Next</span>
        </button>
      </div>
    </div>

    <script>
      $("#header").load("widgets/header.html");
      $(document).ready(function () {
        $("#first-block").load("widgets/nav_buttons.html");
      });
      document.getElementById('question-text').textContent = questionText;


      let next_number = parseInt(questionNumber) + 1;
      let previous_number = parseInt(questionNumber) - 1;


      function previous_question() {
        if (parseInt(questionNumber) > 1) {
          const previousNumber = parseInt(questionNumber) - 1;
          location.href = 'http://quiz-game/client/pages/question.php?packageID=' + PackageID + "&questionNumber=" + previousNumber + "&questionCount=" + questionCount;
        }
      }

      function next_question() {
        let user_answer = document.getElementById('answer').value;
        localStorage.setItem("user_answer" + questionNumber, user_answer);
        if (parseInt(questionNumber) < questionCount) {
          const nextNumber = parseInt(questionNumber) + 1;
          location.href = 'http://quiz-game/client/pages/question.php?packageID=' + PackageID + "&questionNumber=" + nextNumber + "&questionCount=" + questionCount;
        } else {
          location.href = 'http://quiz-game/client/pages/package_select.php';
        }
      }
      if (questionNumber == questionCount) {
        document.getElementById('next-button').textContent = "Finish";
      }
      if (questionNumber == 1) {
        document.getElementById('previous-button').style.display = "none";
      }
    </script>
    <script type="module" src="../src/js/get_questions.js"></script>

</html>