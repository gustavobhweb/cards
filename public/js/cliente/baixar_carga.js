$(function(){
    $.get('/cliente/ajax-listar-remessas', function(response) {
        $('#search-input').autocomplete({
            source: response
        });    
    })

    $('.not-downloaded').click(function() {
        var self = $(this);
        self.removeClass('not-downloaded')
            .addClass('downloaded')
            .find('.glyphicon')
            .removeClass('glyphicon-download-alt')
            .addClass('glyphicon-ok-sign');

    });
    
});