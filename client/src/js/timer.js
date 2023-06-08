let timeLeft = parseInt(localStorage.getItem('timeLeft'));
if(timeLeft > 0){
}else{
  timeLeft = 90;
}
function secondsToTime(seconds) {
    const hours = Math.floor(seconds / 3600);
    const minutes = Math.floor((seconds % 3600) / 60);
    const sec = seconds % 60;
    return [hours, minutes, sec]
      .map(v => v < 10 ? "0" + v : v)
      .join(":");
}

const timer = setInterval(() => {
    $("#timer").html("Time left:"+secondsToTime(timeLeft));
  timeLeft--;
  localStorage.setItem('timeLeft', timeLeft);
  if (timeLeft <= 59){
    $('#timer').css('color', "red");
  }
  if (timeLeft === 0) {
    clearInterval(timer);
    location.href = 'http://quiz-game/client/pages/package_select.php';
    $("#timer").html("Time is up");
    // Выполнение события после конца времени
  }
}, 1000);