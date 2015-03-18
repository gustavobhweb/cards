window.fbAsyncInit = function(){


    FB.init({
        appId      : '203048596548089',
        xfbml      : true,
        version    : 'v2.2'
    });


    $(function(){

        var facebookCallAction;

        var me = function(){
            FB.api('/me', function(fbData){
                if (!$.isEmptyObject(fbData.error)) {

                    new wmDialog('Erro ao processar os dados. Atualize a página e tente novamente.', {
                        isHTML: true,
                        width: 350,
                        height: 240,
                        btnCancelEnabled: false,
                        title: 'Alerta'
                    }).open();
                }

                $.post('/aluno/save-facebook-photo', {idfacebook: fbData.id}, function(response){
                    $('.loading').hide();
                    $('#enviar-foto').fadeOut(400, function(){
                        $('.box-photo').animate({margin: '2% auto'});
                        $('#crop').fadeIn();
                        var url = response.url;

                        $('.jcrop').html('<div class="cropMain"></div><p>Ajustar o zoom:</p><div class="cropSlider"></div>');
                        var one = new CROP();
                        one.init('.jcrop');
                        one.loadImg(url);




                        $('.btn-make-crop').click(function(){
                            var _thisBtn = $(this);
                            $('.return-modal-menu').hide(0, function(){
                                $('#crop').fadeOut(0, function(){
                                    $('.loading').show();
                                });
                                _thisBtn.html('Salvando...');
                                _thisBtn.attr('disabled', 'disabled');
                            });

                            var formData = $.extend({img: response.base64}, coordinates(one));

                            $.ajax({
                                url: '/aluno/cropimage',
                                type: 'POST',
                                data: formData,
                                success: function(data) {
                                    $('.modal-photo').fadeOut(500, function(){
                                        $('.loading').hide();
                                        $('#crop').hide();
                                        $('#enviar-foto').show();
                                        $('.userPhoto.after-choice').attr({
                                            'src': data.url + '?' + new Date().getTime(),
                                            'data-selected': 'true'
                                        });
                                    });
                                },
                                error: function()
                                {
                                    alert('Problemas na conexão!');
                                    $('.loading').hide();
                                }
                            });
                            imageFile = null;
                        });
                    });
                });
            });
        }

        FB.getLoginStatus(function(response) {

            if (response.status == 'connected') {
                facebookCallAction = function(e){
                    e.preventDefault();
                    me();
                }

            } else {

                facebookCallAction = function(e){
                    e.preventDefault();
                    FB.login(function(response) {
                        if (response.authResponse) {
                            me();
                            console.log('after timeout, call this');
                        }
                    });
                }

            }

            $(document).on('click', '.btn-fb-photo', function(e){
                $('#enviar-foto').hide(0, function(){
                    $('.loading').show();
                })
                $('.btn-make-crop').removeAttr('disabled');
                $('.btn-make-crop').html('Salvar');
                $('.return-modal-menu').show();
                facebookCallAction(e);
            });
        });


    });
};

(function(d, s, id){
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) {return;}
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));