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
            <p id="profile_name"><b>Oluwatobi Olowu</b>
              <br><span style="font-size:15px;">Examiner</span>
            </p>
          </div>
        </div>
      </div>

      <div style="display: flex;position:relative;margin-top:30px;">
        <div style="flex: 1;" class="info-block">
          <div class="square">
            <img src="http://quiz-game/client/assets/images/check.png" alt="Image" class="icon">
          </div>
          <span id="profile_name"><b>89.28%</b> <br>
            <p style="font-size:15px;">Training accuracy</p>
          </span>
        </div>
        <div style="flex: 1;" class="info-block">
          <div class="square">
            <img src="http://quiz-game/client/assets/images/check.png" alt="Image" class="icon">
          </div>
          <span id="profile_name"><b>76.28%</b> <br>
            <p style="font-size:15px;">Competition accuracy</p>
          </span>
        </div>
      </div>
      <div style="display: flex;position:relative;margin-top:30px;">
        <div style="flex: 1;" class="info-block">
          <div class="square">
            <img src="http://quiz-game/client/assets/images/package.png" alt="Image" class="icon">
          </div>
          <span id="profile_name"><b>3</b> <br>
            <p style="font-size:15px;">Packages created</p>
          </span>
        </div>
        <div style="flex: 1;" class="info-block">
          <div class="square">
            <img src="http://quiz-game/client/assets/images/brown_flag.png" alt="Image" class="icon">
          </div>
          <span id="profile_name"><b>3</b> <br>
            <p style="font-size:15px;">1x1 Competitions Wins</p>
          </span>
        </div>
      </div>
      <div style="display: flex;position:relative;margin-top:30px;">
        <div style="flex: 1;" class="info-block">
          <div class="square">
            <img src="http://quiz-game/client/assets/images/timer.png" alt="Image" class="icon">
          </div>
          <span id="profile_name"><b>27 May 2023</b> <br>
            <p style="font-size:15px;">Last Training date</p>
          </span>
        </div>
      </div>
      <button id="logout">
        <img src="http://quiz-game/client/assets/images/logout_white.png" alt="Image">
        <span class="button-text">Log Out</span>
      </button>
    </div>

    <script>
      $("#header").load("widgets/header.html");
      $(document).ready(function () {
        $("#first-block").load("widgets/nav_buttons.html");
      });

      $("#logout").on("click", function () {
        localStorage.removeItem("user");
        localStorage.removeItem("token");
        window.location.href = "http://quiz-game/client/pages/index.php";
      });
    </script>


</html>