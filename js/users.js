function deleteUser(userID){
    $.post("ajax.php",
    {
        action: 'deleteUser',
        userID: userID
    },
    function(data, status) {
        var response = $.parseJSON(data);
        if(response.status == 'success'){
            location.reload();
            // target.toggleClass("fa-toggle-off");
        }else{
            alert(response.message);
        }
    });
}
function toggleAdmin(userID){
    var target = $(event.target);

    $.post("ajax.php",
    {
        action: 'toggleAdmin',
        userID: userID
    },
    function(data, status) {
        var response = $.parseJSON(data);
        if(response.status == 'success'){
            target.toggleClass("fa-flip-horizontal");
            // target.toggleClass("fa-toggle-off");
        }else{
            alert(response.message);
        }
    });
}
