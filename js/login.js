$('form').on('submit', function(event) {
    event.preventDefault();
    $.post("ajax.php",
        $( this ).serialize(),
        function(data, status) {
            var response = $.parseJSON(data);
            if(response.status == 'success'){
                window.location.href = "index.php";
            }else{
                alert(response.message);
            }
        }
    );
});
