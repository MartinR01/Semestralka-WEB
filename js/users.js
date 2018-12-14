function deleteUser(userID){
    $.post("ajax.php",
    {
        action: 'deleteUser',
        userID: userID
    },
    function(data, status) {
        location.reload();
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
            target.toggleClass("fa-toggle-on");
            target.toggleClass("fa-toggle-off");
        }else{
            alert(response.message);
        }
    });
}
