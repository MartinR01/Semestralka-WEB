$('input[type=radio][name=form]').change(function() {
    if(this.value == 'actor'){
        $('#movieForm').hide();
        $('#actorForm').show();
    }else if(this.value == 'movie'){
        $('#actorForm').hide();
        $('#movieForm').show();
    }
});
