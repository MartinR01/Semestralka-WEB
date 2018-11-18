// check if already favorite
let params = new URLSearchParams(window.location.search);
let movieID = params.get('id');
let userID = 1;

$.post("isFav.php",
  {
    userID: userID,
    movieID: movieID
  },
  function(data, status){
    if(data > 0){
      $("#favBtn").toggleClass("fas");
      $("#favBtn").toggleClass("far");
    }
  }
);


function toggleFav() {
  var action = ($("#favBtn").hasClass("fas")) ? "removeFav.php" : "addFav.php";
  $("#favBtn").toggleClass("fas");
  $("#favBtn").toggleClass("far");

  $.post(action,
    {
        userID: userID,
        movieID: movieID
    },
    function(data, status) {
    });
}
