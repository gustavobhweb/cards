$(document).ready(function(){

    var closeImgShow = function(){
        $('.img-show').stop().fadeOut();
    };

    $('.img-preview').click(function(){
        var $imgModal = $(this).siblings('.img-show');
        var src = $(this).attr('src');
        if (!$imgModal.is(':visible')) {
            $imgModal
                .css({'background-image': 'url('+src+')'})
                .fadeIn();
        } else {
            $imgModal.fadeOut();
        }
    });

    $('.img-show--close').click(closeImgShow);

    $(document).bind('keyup', function(event) {
        if (event.keyCode == 27) {
            closeImgShow();
        }
    });


    
});