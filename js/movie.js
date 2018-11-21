let userID = 1;

function toggleFav(movieID) {
    let btn = $("#favBtn");
    btn.toggleClass("fas");
    btn.toggleClass("far");

    $.post("favorite.php",
    {
        action: 'favorite',
        userID: userID,
        movieID: movieID
    },
    function(data, status) {
    });
}

function comment(movieID) {
    let text = $('#comment').val();
    if(text.length == 0){
        alert('empty comment!');
        return;
    }
    $.post("favorite.php",
        {
            action: 'comment',
            userID: userID,
            movieID: movieID,
            text: text
        },
        function(data, status) {
            location.reload();
        }
    );
}
