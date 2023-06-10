$(document).ready(function () {
    $("#home-button").click(function () {
        // Redirect to the desired page
        window.location.href = "http://quiz-game/client/pages/index.php";
    });
});
$(document).ready(function () {
    $("#profile-button").click(function () {
        // Redirect to the desired page
        if (localStorage.getItem("ID") == null) {
            window.location.href = "http://quiz-game/client/pages/sign_in.php";
        } else {
            window.location.href = "http://quiz-game/client/pages/profile.php";
        }
    });
});
$(document).ready(function () {
    $("#logout-button").click(function () {
        localStorage.clear();
        window.location.href = "http://quiz-game/client/pages/sign_in.php";
    });
});

if (localStorage.getItem("ID") != null) {
    $("#logout-button").show();
} else {
    $("#logout-button").hide();
    $(".profile-button-text").text("Sign In");
}