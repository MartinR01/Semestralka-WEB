let userID = 1;

function toggleFav(movieID) {
    let btn = $("#favBtn");
    btn.toggleClass("fas");
    btn.toggleClass("far");

    $.post("favorite.php",
    {
        userID: userID,
        movieID: movieID
    },
    function(data, status) {
    });
}
