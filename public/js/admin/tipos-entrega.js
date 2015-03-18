$(function(){

    var modal = new wmDialog

    $(document).on('click', '.change-status', function(e){

        var $self = $(this),
            // se tem a classe ativar, então é enviado um "true"
            status = $self.hasClass('ativar') ? 1 : 0,

            id     = $self.data('id')

        $.ajax({
            url: '/admin/ajax-alterar-status-tipo-entrega/{0}'.format(id),
            type: 'PUT',
            data: {status: status},
            success: function (response) {

                if (response.error) {

                    return modal.html(response.error).open();
                }


                // verificamos o status atual inverso, para realizar as modifições no botão

                console.log(status);

                if (!status) {

                    $self
                        .addClass('wm-btn-blue ativar')
                        .removeClass('desativar')
                        .html('Ativar');

                } else {
                    $self
                        .addClass('desativar')
                        .removeClass('ativar wm-btn-blue')
                        .html('Desativar');
                }


                var message = 'O tipo de entrega foi {0} com sucesso';

                return modal.html(message.format(status ? 'ativada' : 'desativada')).open();
            },

            error: function () {

            }
        });

    });

    

});