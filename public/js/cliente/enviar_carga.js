$(function(){
   	var $fileExcel = $(':file[name=excel]'),
       $fakeFileExcel = $('#fake-file-excel'),
       $inputCaptcha = $('#captcha'),
       $inputNome = $('#nome'),
       $inputCpf = $('#cpf');


    $inputCpf.mask('999.999.999-99');

    $fileExcel.hide().change(function(){
       $fakeFileExcel.html($(this).val());
    });

    $fakeFileExcel.click(function(){
        $fileExcel.trigger('click');
    });

    $('#slc-modelo-tipo').on('change', function()
    {
    	$('#ficha_tecnica_id').val($(this).val());
    	var url = $("#btn-download-model").data('href') + '/' + $(this).val();
    	$("#btn-download-model").attr('href', url);
    });

    $modalAlternative = $('.modal-alternative');
    $modalClose = $modalAlternative.find('.close');
    $modalConfirm = $modalAlternative.find('.confirm');

    $modalClose.on('click', function()
    {
        $modalAlternative.fadeOut();
    });

    $modalConfirm.on('click', function()
    {
        var captcha = $inputCaptcha.val();
        var nome = $inputNome.val();
        var cpf = $inputCpf.val();

        $inputNome.focus().removeClass('input-error');
        $inputCpf.focus().removeClass('input-error');
        $inputCaptcha.focus().removeClass('input-error');

        if (nome == '' || nome == null) {
            $inputNome.focus().removeClass('input-valid').addClass('input-error');
        } else if (cpf == '' || cpf == null) {
            $inputNome.focus().removeClass('input-error').addClass('input-valid');
            $inputCpf.focus().removeClass('input-valid').addClass('input-error');
        } else {
            $inputNome.focus().removeClass('input-error').addClass('input-valid');
            $inputCpf.focus().removeClass('input-error').addClass('input-valid');
            try{
            Captcha().getRequest(captcha, {
                success: function(response)
                {
                    if (response.status) {
                        $inputNome.focus().removeClass('input-error').addClass('input-valid');
                        $inputCpf.focus().removeClass('input-error').addClass('input-valid');
                        $inputCaptcha.focus().removeClass('input-error').addClass('input-valid');
                        $modalAlternative.fadeOut(function()
                        {
                            $('#send-form-button').click();
                        });
                    } else {
                        $inputCaptcha.focus()
                                     .removeClass('input-valid')
                                     .addClass('input-error')
                                     .val('')
                                     .attr('placeholder', 'Código incorreto');
                    }
                }
            });
            } catch(e) {
                $('#captcha').focus().removeClass('input-valid').addClass('input-error');
                return false;
            }
        }
    });

    $('#fake-send-button').on('click', function()
    {
        $modalAlternative.fadeIn();
    });

    $(window).on('keyup', function(event)
    {
        if (event.keyCode == 27) {
            $modalClose.click();
        }
    });
   
    uploader();

});

function uploader(){
        
    var bar = $('.bar');
    var percent = $('.percent');
    var status = $('#status');
    var loading = $('#loading');
       
    $('#frm-enviar-carga').ajaxForm({
        beforeSend: function() {
            status.empty();
            var percentVal = '0%';
            bar.width(percentVal)
            percent.html(percentVal);
            loading.show();
        },
        uploadProgress: function(event, position, total, percentComplete) {
            var percentVal = percentComplete + '%';
            bar.width(percentVal)
            percent.html(percentVal);
        },
        success: function() {
            var percentVal = '100%';
            bar.width(percentVal)
            percent.html(percentVal);
        },
        complete: function(xhr) {
            loading.hide();
            status.fadeIn();
            console.log(xhr);
            if (xhr.responseJSON.status) {
                status.addClass('success').html('Carga realizada com sucesso! Agora vá em enviar fotos para continuar com o processo de solicitação. ');
            } else {
                status.removeClass('success').html(xhr.responseJSON.message);
            }
        }
    }); 

}