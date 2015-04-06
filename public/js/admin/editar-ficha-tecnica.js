$(function(){

    var $fields = $('.fields');

    var $inputCampo = $('#input-campo');

    var $inputImageFront = $('[name=foto_frente]')

    var $inputImageBack = $('[name=foto_verso]');

    var $form = $('#form-cadastro');

    var modal = new wmDialog()

    $form.submit(function(e){

        e.preventDefault();

        var $btn  = $("#btn-send"),
            $self = $(this),
            id    = $self.data('id');

        var formData = new FormData;

        var inputs = $(this).objectForm();

        $.each(inputs, function(key, value){
            formData.append(key, value);
        });


        $fields.find('.input-campo').each(function(i){
            var field = 'campos[{0}]'.format(i);
            formData.append(field, $(this).val())   
        });


        if ($inputImageFront.is(':enabled')) {

            formData.append('foto_frente', $inputImageFront.prop('files')[0]);
        }

        if ($inputImageBack.is(':enabled')) {

            formData.append('foto_verso', $inputImageBack.prop('files')[0]);
        }


        $.ajax({
            url: '/admin/ajax-editar-ficha-tecnica/' + id,
            type: 'POST',
            processData: false,
            contentType: false,
            cache: false,
            data: formData,
            beforeSend: function() {
                $self.attr({disabled: true});
            },
            success: function(response) {

                if (! response.error) {

                    modal.html('Ficha técnica atualizada com sucesso!').open()

                } else {

                    modal.html(response.error).open();
                }

                $self.removeAttr('disabled');
            },
            error: function(jqXHR, textStatus, error)
            {
                $self.attr({disabled: false});
                console.log(arguments)
                return modal.html(error).open()               
            }
        });
    });

    $('#tem-foto-s').click(function()
    {
        $('#tem-dados-s').click();
        verificarChecked();
    });

    $('#tem-dados-s').click(function()
    {
        verificarChecked();   
        $('.campo-chave').attr('required', 'required');
    });

    $('#tem-dados-n').click(function()
    {
        verificarChecked();
        $('.campo-chave').removeAttr('required');
    });

    verificarChecked();
    
});

function verificarChecked()
{
    if ($('#tem-dados-s:checked').length) {
        $('.dados-section').fadeIn();
    } else if ($('#tem-dados-n:checked').length) {
        $('.dados-section').fadeOut();
    }
}