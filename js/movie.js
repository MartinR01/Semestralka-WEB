let params = new URLSearchParams(window.location.search);
let movieID = params.get('id');

function toggleFav() {
    let btn = $("#favBtn");
    btn.toggleClass("fas");
    btn.toggleClass("far");

    $.post("ajax.php",
    {
        action: 'favorite',
        movieID: movieID
    },
    function(data, status) {
    });
}

function comment() {
    let text = CKEDITOR.instances.comment.getData();

    if(text.length == 0){
        alert('empty comment!');
        return;
    }
    $.post("ajax.php",
        {
            action: 'comment',
            movieID: movieID,
            text: text
        },
        function(data, status) {
            // console.log(data);
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
            movieID: movieID,
            rating: rating,
            text: text
        },
        function(data, status) {
            var response = $.parseJSON(data);
            if(response.status == 'success'){
                location.reload();
            }else{
                alert(response.message);
            }
        }
    );
}
