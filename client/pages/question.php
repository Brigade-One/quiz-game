<html>

<head>
    <title>Sign Up</title>
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
      questionText = localStorage.getItem("question"+questionNumber);
      answerText = localStorage.getItem("answer"+questionNumber);
      hintText = localStorage.getItem("hint"+questionNumber);
      console.log(questionText);
      //console.log(questionNumber);
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
  <div  id="home"style="display:flex">
    <div style="flex:9">
    <p><b>Quiz</b><br>
    <span id="undertext">Answer a question below</span></p>
    </div>
    <div style="flex:3;text-align: left;">
    <b><p id="timer"><p></b>
    </div>
</div>
  <div id="question_info">
  <div id="quesion_picture" style="flex:1">
  <div>
  <div id="question_text" style="flex:1">
  <p><span style="font-size:20px"><b>Question 2/5</b></span>
    <br>
    <span>Theme: Unknown</span>
      <br>
    <span id="question-text">Guy Bailey, Roy Hackett and Paul Stephenson made history in 1963, as part of a protest against a bus company that refused to employ black and Asian drivers in which UK city?</span>
  </div>
</div>
</div>
</div>
  <div id="answer_options">
    <p>
      <span style="font-size:17px;"><b>Choose answer</b></span>
      <form>
      <input type="radio" id="option1" name="options" value="1">
      <label for="option1" id="optionText1">Option 1</label><br>
      <input type="radio" id="option2" name="options" value="2">
      <label for="option2" id="optionText2">Option 2</label><br>
      <input type="radio" id="option3" name="options" value="3">
      <label for="option3" id="optionText3">Option 3</label><br>
      <input type="radio" id="option4" name="options" value="4">
      <label for="option4" id="optionText4">NOU</label>
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

      function fillAnswers(){
        let options = [1, 2, 3, 4];
        let answers = [7,1,6,answerText];
        // перемешиваем массив
        for (let i = options.length - 1; i > 0; i--) {
            let j = Math.floor(Math.random() * (i + 1));
            [options[i], options[j]] = [options[j], options[i]];
        }

        for (let i = answers.length - 1; i > 0; i--) {
            let j = Math.floor(Math.random() * (i + 1));
            [answers[i], answers[j]] = [answers[j], answers[i]];
        }
        // выбираем элементы по одному
        while (options.length > 0) {
            let choice = options.pop();
            let answer_choice = answers.pop();
            document.getElementById('optionText'+choice).textContent = answer_choice;
            //console.log(choice);
        }
        
      }

      fillAnswers();
      //console.log(parseInt(questionNumber)+1);
      let next_number=parseInt(questionNumber)+1;
      let previous_number = parseInt(questionNumber)-1;

      function previous_question(){
        if(parseInt(questionNumber) == 1){
        }else{
          location.href = 'http://quiz-game/client/pages/question.php?packageID=' + PackageID+"&questionNumber="+previous_number;
        }
      }

      function next_question(){
        let selectedRadio = document.querySelector('input[name="options"]:checked');
        let selectedValue = selectedRadio.value;
        let user_answer = document.getElementById('optionText'+selectedValue).textContent;
        localStorage.setItem("user_answer"+questionNumber, user_answer);
        if(questionNumber == localStorage.getItem("number_of_questions")){
          location.href = 'http://quiz-game/client/pages/package_select.php';
        }else{
          location.href = 'http://quiz-game/client/pages/question.php?packageID=' + PackageID+"&questionNumber="+next_number;
        }

      };
</script>
<script type="module" src="../src/js/get_questions.js"></script>
    

</html>