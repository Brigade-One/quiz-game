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
    const xhr = new XMLHttpRequest();
    xhr.open("GET", "../../server/server.php/" + "package_questions" + "?packageID=" + <?php echo json_encode($_GET["packageID"]); ?>, false);
    xhr.onreadystatechange = () => {
      if (xhr.readyState === XMLHttpRequest.DONE) {
        if (xhr.status === 200) {
          const response = JSON.parse(xhr.responseText);
          let counter = 1;
          try {
            for (const i of response) {
              let result_i = JSON.parse(i);
              console.log(result_i);
              localStorage.setItem("QID" + counter, result_i.questionID);
              localStorage.setItem("question" + counter, result_i.question);
              localStorage.setItem("answer" + counter, result_i.answer);
              localStorage.setItem("hint" + counter, result_i.hint);
              counter = counter + 1;

            }
          } catch (error) {
            console.log(error);
          }
          localStorage.setItem("number_of_questions", counter - 1);

          for (let i = 1; i <= counter - 2; i++) {
            var alter_i = i + 1;
            var clonedQuestionInfo = $(".question_info:first").clone();
            var existingQuestionInfo = $(".question_info");
            var totalQuestions = existingQuestionInfo.length;
            var questionNumber = clonedQuestionInfo.find(".question_number");
            var questionText = clonedQuestionInfo.find(".question_text_value");
            questionText.attr("id", "text" + alter_i);
            var questionAns = clonedQuestionInfo.find(".answer_value");
            questionAns.attr("id", "ans" + alter_i);
            var questionText = clonedQuestionInfo.find(".hint_value");
            questionText.attr("id", "hint" + alter_i);
            // Clear input values
            clonedQuestionInfo.find("input[type='text']").val("");

            questionNumber.text("#" + alter_i);
            $("#question").append(clonedQuestionInfo);
          }

          for (let i = 1; i <= counter - 1; i++) {
            $("#text" + i).val(localStorage.getItem("question" + i));
            $("#ans" + i).val(localStorage.getItem("answer" + i));
            $("#hint" + i).val(localStorage.getItem("hint" + i));
          }
        }
      }
    };
    xhr.send();
  </script>
  <script>
    const PackageID = <?php echo json_encode($_GET["packageID"]); ?>;
    const questionNumber = <?php echo json_encode($_GET["questionNumber"]); ?>;
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
                    <?php echo $_GET['questionNumber']; ?>/ {questionCount}
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

      let item = parseInt(localStorage.getItem("user_answer"+ questionNumber));
      if(item){
      document.getElementById('answer').value = item;
      }


      questionText = localStorage.getItem("question" + questionNumber);
      answerText = localStorage.getItem("answer" + questionNumber);
      hintText = localStorage.getItem("hint" + questionNumber);
      const questionCount = localStorage.getItem("number_of_questions");
      let next_number = parseInt(questionNumber) + 1;
      let previous_number = parseInt(questionNumber) - 1;

      document.getElementById('question-text').textContent = questionText;

      function previous_question() {
        if (parseInt(questionNumber) > 1) {
          let user_answer = document.getElementById('answer').value;
          localStorage.setItem("user_answer" + questionNumber, user_answer);
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
          location.href = 'http://quiz-game/client/pages/package_select.php?packageID=' + PackageID;
        }
      }
      if (questionNumber == questionCount) {
        document.getElementById('next-button').textContent = "Finish";
      }
      if (questionNumber == 1) {
        document.getElementById('previous-button').style.display = "none";
      }
      if (document.getElementById('next-button').textContent == "Finish") {
        localStorage.setItem("lastTrainPackageID", PackageID);
        document.getElementById('next-button').onclick = function () {
          let user_answer = document.getElementById('answer').value;
          localStorage.setItem("user_answer" + questionNumber, user_answer);
          location.href = 'http://quiz-game/client/pages/package_select.php';
        }

      }

    </script>


</html>