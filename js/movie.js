let userID = 1;

function toggleFav(movieID) {
    var btn = $("#favBtn");
    btn.toggleClass("fas");
    btn.toggleClass("far");

  $.post("favorite.php",
    {
        action: "toggle",
        userID: userID,
        movieID: movieID
    },
    function(data, status) {
    });
}
