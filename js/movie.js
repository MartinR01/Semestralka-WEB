function toggleFav(moiveID) {
  $("#favBtn").toggleClass("fas");
  $("#favBtn").toggleClass("far");

  $.post("favorite.php",
    {
        action: "toggle",
        userID: userID,
        movieID: movieID
    },
    function(data, status) {
    });
}
