let params = new URLSearchParams(window.location.search);
let movieID = params.get('id');
let userID = 1;

function toggleFav() {
    let btn = $("#favBtn");
    btn.toggleClass("fas");
    btn.toggleClass("far");

    $.post("ajax.php",
    {
        action: 'favorite',
        userID: userID,
        movieID: movieID
    },
    function(data, status) {
    });
}

function comment() {
    let text = $('#comment').val();
    if(text.length == 0){
        alert('empty comment!');
        return;
    }
    $.post("ajax.php",
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

function rate() {
    let text=$('#ratingText').val();
    let rating = $('#rating').val();

    $.post("ajax.php",
        {
            action: 'rate',
            userID: userID,
            movieID: movieID,
            rating: rating,
            text: text
        },
        function(data, status) {
            location.reload();
        }
    );
}
