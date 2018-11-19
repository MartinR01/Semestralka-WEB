// check if already favorite
let params = new URLSearchParams(window.location.search);
let movieID = params.get('id');
let userID = 1;

$.post("favorite.php",
  {
    action: "isFav",
    userID: userID,
    movieID: movieID
  },
  function(data, status){
    if(data == 1){
      $("#favBtn").toggleClass("fas");
      $("#favBtn").toggleClass("far");
    }
  }
);


function toggleFav() {
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
