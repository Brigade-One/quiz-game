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
      <div style="display: flex;">
        <div style="flex: 1;">
          <img src="http://quiz-game/client/assets/images/profile_image.jpg" alt="Image" id="profile-picture">
        </div>

        <div style="flex: 4;">
          <div class="top">
            <p id="profile_name"><b>Oluwatobi Olowu</b><br>
              <span style="font-size:15px;" id="user_status">Examiner</span>
            </p>
          </div>
        </div>
      </div>

      <div style="display: flex;position:relative;margin-top:30px;">
        <div style="flex: 1;" class="info-block">
          <div class="square">
            <img src="http://quiz-game/client/assets/images/check.png" alt="Image" class="icon">
          </div>
          <span id="profile_name"><b>Training accuracy</b> <br>
            <p style="font-size:15px;" id="trainingAccuracy">Training accuracy</p>
          </span>
        </div>
        <div style="flex: 1;" class="info-block">
          <div class="square">
            <img src="http://quiz-game/client/assets/images/check.png" alt="Image" class="icon">
          </div>
          <span id="profile_name"><b>Competition accuracy</b> <br>
            <p style="font-size:15px;" id="competitionAccuracy">Competition accuracy</p>
          </span>
        </div>
      </div>
      <div style="display: flex;position:relative;margin-top:30px;">
        <div style="flex: 1;" class="info-block">
          <div class="square">
            <img src="http://quiz-game/client/assets/images/package.png" alt="Image" class="icon">
          </div>
          <span id="profile_name"><b>Packages created</b> <br>
            <p style="font-size:15px;" id="packagesCreated">Packages created</p>
          </span>
        </div>
        <div style="flex: 1;" class="info-block">
          <div class="square">
            <img src="http://quiz-game/client/assets/images/brown_flag.png" alt="Image" class="icon">
          </div>
          <span id="profile_name"><b>1x1 Competitions Wins</b> <br>
            <p style="font-size:15px;" id="oneByOneWins">1x1 Competitions Wins</p>
          </span>
        </div>
      </div>
      <div style="display: flex;position:relative;margin-top:30px;">
        <div style="flex: 1;" class="info-block">
          <div class="square">
            <img src="http://quiz-game/client/assets/images/timer.png" alt="Image" class="icon">
          </div>
          <span id="profile_name"><b>Last Training date</b> <br>
            <p style="font-size:15px;" id="lastTrainingDate">Last Training date</p>
          </span>
        </div>
      </div>
      <button id="logout">
        <img src="http://quiz-game/client/assets/images/logout_white.png" alt="Image">
        <span class="button-text">Log Out</span>
      </button>
    </div>
  </div>

  <script>
    $("#header").load("widgets/header.html");
    $(document).ready(function () {
      $("#first-block").load("widgets/nav_buttons.html");
    });

    let user_name_storage_c = localStorage.getItem("username");
    let status_numeral = localStorage.getItem("role");
    let user_status = "Guest";
    if (status_numeral == 1) {
      user_status = "Examiner";
    }
    if (status_numeral == 0) {
      user_status = "Regular User";
    }
    if (user_name_storage_c != "Guest") {
      if (user_name_storage_c != null) {
        document.getElementById("profile_name").innerHTML = user_name_storage_c + '</b><br><span style="font-size:15px;">' + user_status + '</span>';
      }
    }

    $("#logout").on("click", function () {
      localStorage.clear();
      window.location.href = "http://quiz-game/client/pages/sign_in.php";
    });

    let lastTrainingDate;
    let trainingAccuracy;
    let competitionAccuracy;
    let packagesCreated;
    let oneByOneWins;
    fetchAchievements();

    function fetchAchievements() {
      const xhr = new XMLHttpRequest();
      xhr.open("GET", "../../server/server.php/achievements?userID=" + localStorage.getItem("ID"));
      xhr.onload = () => {
        const data = JSON.parse(xhr.response);

        lastTrainingDate = data.trainingLastDate
        let formattedDate = new Date(lastTrainingDate).toLocaleDateString('en-US', {
          day: '2-digit',
          month: 'long',
          year: 'numeric'
        });
        trainingAccuracy = data.trainingAccuracy;
        competitionAccuracy = data.competitionAccuracy;
        packagesCreated = data.createdPackagesNumber;
        oneByOneWins = data.oneByOneWins;

        document.getElementById("lastTrainingDate").innerHTML = formattedDate;
        document.getElementById("trainingAccuracy").innerHTML = trainingAccuracy + " %";
        document.getElementById("competitionAccuracy").innerHTML = competitionAccuracy + " %";
        document.getElementById("packagesCreated").innerHTML = packagesCreated;
        document.getElementById("oneByOneWins").innerHTML = "Temporarily Unavailable";
      };
      xhr.send();
    }
  </script>
</body>

</html>