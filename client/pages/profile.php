<html>

<head>
  <title>Profile</title>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link rel="stylesheet" href="http://quiz-game/client/src/css/main_pages.css">
  <link rel="stylesheet" href="http://quiz-game/client/src/css/profile_pages.css">
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@700&display=swap');
  </style>
  
</head>

<body>


  <header>
    <div id="header"></div>
  </header>

  <div style="display: flex;">
    <div style="flex: 1;" id="first-block"> </div>

    <div style="flex: 5" id="second-block">

      <div style="display: flex;height=200px;">
        <div style="flex: 1;">
          <img src="http://quiz-game/client/assets/images/profile_image.jpg" alt="Image" id="profile-picture">
        </div>

        <div style="flex: 4;height=200px;">
          <div class="top">
            <b><p id="profile_name">Anonymous</b>
              <br><span style="font-size:15px;">Guest</span>
            </p>
          </div>

          <div class="bottom" style="display: flex;">
            <div style="flex: 1;">
            </div>
            <div style="flex: 1;" id="fastest-time">
              <img src="http://quiz-game/client/assets/images/vector.jpg" alt="Image" class="flag">
              <span id="profile_name"><b>27min</b>
                <br>
                <p style="font-size:15px;">Fastest time</p>
              </span>
            </div>
            <div style="flex: 1;" id="correct-answers">
              <img src="http://quiz-game/client/assets/images/vector.jpg" alt="Image" class="flag">
              <span id="profile_name"><b>200</b>
                <br>
                <p style="font-size:15px;">Correct Answers</p>
              </span>
            </div>
          </div>
        </div>
      </div>

      <div style="display: flex;position:relative;margin-top:30px;">
        <div style="flex: 1;" class="flag-result">
          <img src="http://quiz-game/client/assets/images/gray_flag.png" alt="Image" class="flag">
          <span id="profile_name"><b>200</b> <br>
            <p style="font-size:15px;">Correct Answers</p>
          </span>
        </div>
        <div style="flex: 1;" class="flag-result">
          <img src="http://quiz-game/client/assets/images/brown_flag.png" alt="Image" class="flag">
          <span id="profile_name"><b>200</b> <br>
            <p style="font-size:15px;">Correct Answers</p>
          </span>
        </div>
      </div>
      <button id="logout">
        <img src="http://quiz-game/client/assets/images/logout.png" alt="Image">
        <span class="button-text">Log Out</span>
      </button>
    </div>

    <script>
      $("#header").load("widgets/header.html");
      $(document).ready(function () {
        $("#first-block").load("widgets/nav_buttons.html");
      });

        let user_name_storage_c = localStorage.getItem("username");
        let status_numeral = localStorage.getItem("role");
        let user_status = "Guest";
        if(status_numeral == 1){
          user_status = "Examiner";
        }
        if(status_numeral == 0){
          user_status = "Regular User";
        }
        if(user_name_storage_c != "Guest"){
            if(user_name_storage_c != null){
                document.getElementById("profile_name").innerHTML = user_name_storage_c+'</b><br><span style="font-size:15px;">'+user_status+'</span>';
            }             
        }

      $("#logout").on("click", function () {
            localStorage.clear();
            window.location.href = "http://quiz-game/client/pages/sign_in.php";
        });
    </script>


</html>