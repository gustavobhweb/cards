var i = 0;


var reader = new FileReader();


function refreshImg(el)
{
    $('.box-photo').animate({margin: '2% auto'});

    $('.btn-make-crop').removeAttr('disabled');

    $('.btn-make-crop').html('Salvar');

    $('.return-modal-menu').show();

    var ext = el.val().split('.').slice(-1)[0];

    regexpExtension = /(png|jpg|jpeg|bmp|gif)/gi;

    if (regexpExtension.test(ext)) {

        $('#enviar-foto').fadeOut(400, function(){
            $('#crop').fadeIn();

            var imageFile = el.prop('files')[0];


            console.log(el);

            var url = window.URL.createObjectURL(imageFile);


            $('.jcrop').html('<div class="cropMain"></div><p>Ajustar o zoom:</p><div class="cropSlider"></div>');

            var one = new CROP();

            one.init('.jcrop');

            one.loadImg(url);

            var reader = new window.FileReader();

            $('.btn-make-crop').click(function(){
                
                var elBtn = $(this);

                $('.return-modal-menu').hide(0, function(){
                    $('#crop').fadeOut(0, function(){
                        $('.loading').show();

                    });

                    elBtn.html('Salvando...');

                    elBtn.attr('disabled', 'disabled');

                });

                if (typeof(imageFile) == 'undefined' || imageFile == null) imageFile = el.prop('files')[0];


                var formData = new FormData();

                formData.append('img', imageFile);

                formData.append('ext', ext);


                $.each(coordinates(one), function(key, value){
                    formData.append(key, value);

                });


                $.ajax({
                    url: '/aluno/cropimage',
                    type: 'POST',
                    processData: false,
                    contentType: false,
                    cache: false,
                    data: formData,
                    success: function(data) {
                        $('.modal-photo').fadeOut(500, function(){
                            $('.loading').hide();

                            $('#crop').hide();

                            $('#enviar-foto').show();

                            $('.userPhoto.after-choice')
                                .data('selected', true)
                                .attr({
                                    'src': data.url + '?' + new Date().getTime()
                                });

                        });

                    },
                    error: function()
                    {
                        new wmDialog('Problemas de conexão! Atualize a página e tente novamente.', {
                            height:230,
                            width: 330,
                            btnCancelEnabled: false
                        }).open();

                        $('.loading').hide();

                    }
                });

            });

        });


    } else {
        new wmDialog('A extensão do arquivo escolhido é inválida.', {
                height:230,
                width: 330,
                btnCancelEnabled: false
            }).open();

    }
}

function get_captcha()
{
    $('#captcha').attr('src', '/captcha/?' + new Date().getTime());

}

$(function(){

    $('.box-photo').draggable({
        handle: '.header-modal-photo'
    });

    $('.btn-img-pessoa').click(function(){
        $('.modal-photo').fadeIn();

        $('#avisopermitir').hide();

    });


    $('.btn-close-box').click(function(){
        $('.return-modal-menu').click();

        $('.modal-photo').fadeOut();

        $('.loading').hide();

    });


    $('#save-photo').click(function(){
        var src = $('.userPhoto.preview-modal').attr('src');


        $('.modal-photo').fadeOut(400, function(){
            $('.userPhoto').attr({
                'src': src + '?' + new Date().getTime(),
                'data-selected' : 'true'
            });

            $(':hidden[name=tmp_image]').val(src);

        });

    });


    $(document).on('click', '.return-modal-menu', function(){
        $('.box-photo').animate({margin: '8% auto'});

        $('#webcam, #crop, #flashcam').fadeOut(0, function(){
            $('#enviar-foto').fadeIn();

        });

    });


    $('#form-cadastrar-solicitacao').submit(function(e){

        if ($('.userPhoto').data('selected') == false) {

            new wmDialog('Você deve selecionar a foto', {
                height:230,
                width: 330,
                btnCancelEnabled: false
            }).open();

            e.preventDefault();

            return false;

        }  else if (!verify_captcha($('#captcha-code').val())) {
            new wmDialog('O texto digitado não é o mesmo da imagem', {
                height:230,
                width: 330,
                btnCancelEnabled: false
            }).open();

            get_captcha();

            e.preventDefault();

            return false;

        } else if (!$('#privacidade-ckb').is(':checked')) {
            new wmDialog('Você deve aceitar os termos de uso e políticas de privacidade', {
                height:230,
                width: 330,
                btnCancelEnabled: false
            }).open();

            get_captcha();

            e.preventDefault();

            return false;

        } else {
            return true;

        }

        get_captcha();

    });


    $('#captcha-refresh').on('click', function()
    {
        get_captcha();

    });


    $('#uf').on('change', function ()
    {
        var $ufContext = $(this);

        $.ajax({
            url: '/json/cidades',
            type: 'GET',
            dataType: 'json',
            data: {
                uf_id: $ufContext.val()
            },
            beforeSend: function(){
                var opt = '<option value>Carregando...</option>';

                $('#cidade').html(opt);

            },
            success: function(response){
                console.log(response);

                var opt = '<option value>(Selecione)</option>';

                $('#cidade').html(opt);

                for (key in response) {
                    opt = '<option value="' + response[key] + '">' + response[key] + '</option>';

                    $('#cidade').append(opt);

                }
            },
            error: function(){
                new wmDialog('Problemas na conexão! Atualize a página e tente novamente.', {
                    height:230,
                    width: 330,
                    btnCancelEnabled: false
                }).open();

            }
        });

    });


    $('.btn-verificar-cep').on('click', function()
    {
        var cep = $('#cep').val().replace('-', '');

        var link = 'http://cep.correiocontrol.com.br/' + cep + '.json';

        var $thisContext = $(this);

        $.ajax({
            url: link,
            type: 'GET',
            dataType: 'json',
            beforeSend: function(){
                $thisContext.attr('disabled', 'disabled');

                $thisContext.html('VERIFICANDO...');

            },
            success: function(response){
                $thisContext.html('VERIFICAR');

                $thisContext.removeAttr('disabled');

                //$('#uf').append('<option value="' + response.uf + '" selected>' + response.uf + '</option>');


                $("#uf").find('option:contains('+response.uf+')').prop('selected', 'selected');

                $('#uf').css({color: '#000000'});

                $('#cidade').append('<option value="' + response.localidade + '" selected>' + response.localidade + '</option>');

                $('#cidade').css({color: '#000000'});

                $('#endereco').val(response.logradouro);

                $('#bairro').val(response.bairro);

            },
            error: function(){
                $thisContext.html('VERIFICAR');

                $thisContext.removeAttr('disabled');

                new wmDialog('CEP não encontrado!', {
                    height:230,
                    width: 330,
                    btnCancelEnabled: false
                }).open();

            }
        });
        
    });

});


function verify_captcha(text)
{
    var ret = false;


    $.ajax({
        url: '/verify-captcha',
        type: 'POST',
        dataType: 'json',
        async: false,
        data: {
            text: text
        },
        success: function(response){
            console.log(response);

            ret = response.status;

        }
    });


    return ret;

}

function onSnapClick()
{
    $('#webcam').hide(0, function(){
        $('.loading').fadeIn();

    });

}



$(function(){

    var $userPhoto = $('.userPhoto');

    $userPhoto.error(function(){

        var $self = $(this);

        var src = $self.data('src');

        $self.attr('src', src);

    });

    $('#userfile').change(function(){
        refreshImg($(this));
    });
});