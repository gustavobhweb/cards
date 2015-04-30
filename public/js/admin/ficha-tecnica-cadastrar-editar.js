/** 
    Esse script foi feito para evitar a replicação de código 
    desnecessária entre "cadastra ficha técnica" e "editar ficha técnica" 
*/

$(function(){

    var modal = new wmDialog();

    var $fields = $('.fields');

    var $inputCampo = $('#input-campo');

    var $inputImageFront = $('[name=foto_frente]')

    var $inputImageBack = $('[name=foto_verso]');

    var $form = $('#form-cadastro');

    var $inputCampoChave = $('[name=campo_chave]');


    if (! $fields.find('tbody').has('tr').size()) {

        $fields.hide()
    }


    $inputCampo.autocomplete({

        source: function(request, response){

            $.getJSON('/admin/ajax-campos', {
                q: request.term
            }, function(data){

                response(data);
            });
        },

        minLength: 2
    });

    $inputCampo.keydown(function(event){
        if (event.keyCode == 13) {
            event.preventDefault();
            $('.add-field').click();
        }
    });


    var tplCamposVariaveis = $('#tpl-campos-variaveis').html();
    

    $('.add-field').click(function(){

        // cache do valor atual

        var value = $inputCampo.val();

        var definedNames = $fields.find('.nome-campo-variavel').map(function(){

            // retorna os valores precisamente como String, por isso não uso o .data
            return $(this).attr('data-nome');

        }).toArray();

        if ($.inArray(value, definedNames) !== -1 || !value.length) {

            modal.html('Valor já foi preenchido ou o campo está vazio').open();

            return false;
        }
        

        $('.fields').fadeIn();

        var value = $inputCampo.val();

        var html = _.template(tplCamposVariaveis)({nome: value})

        $fields.find('tbody').append(html);

        $inputCampo.val('');

    });

    $(document).on('click', '.del-field', function(){

        $(this).closest('tr').fadeOut('slow', function(){

            $(this).remove();

            if (! $fields.find('tbody').has('tr').size()) {
                $fields.fadeOut('slow');
            }
        });
    });

    var $triggerImageFront = $('#trigger-foto-frente'),
        $triggerImageBack  = $("#trigger-foto-verso");
    

    $triggerImageFront.add('#image-front').click(function(){

        $inputImageFront.trigger('click');
    })

    $inputImageFront.change(function(){

        var $self = $(this),
            value = $self.val().split('\\').pop();

        $triggerImageFront.html(value);

        var $boxImage = $('#box-preview-image-front'),
            
            $image = $('#image-front'),

            blobUrl = window.URL.createObjectURL($self.prop('files')[0]);

        $boxImage.fadeIn();

        $image.attr('src', blobUrl);

    });

    $triggerImageBack.add('#image-back').click(function(){

        $inputImageBack.trigger('click')
    })

    $inputImageBack.change(function(){

        var $self = $(this),
            value = $self.val().split('\\').pop();

        var $boxImage = $('#box-preview-image-back'),
            $image = $('#image-back'),
            blobUrl = window.URL.createObjectURL($self.prop('files')[0]);

        $boxImage.fadeIn()

        $image.attr('src', blobUrl);
        
        $triggerImageBack.html(value)
    });


    $("#disable-image-back").click(function(e) {
        
        e.preventDefault();

        if ($triggerImageBack.attr('disabled')) {

            $triggerImageBack.add($inputImageBack).removeAttr('disabled');

            $(this).removeClass('activate').html('&times;');

            $("#image-back").removeClass('disabled')


        } else {

            $triggerImageBack.attr({disabled: true});

            $inputImageBack.attr({disabled: true})

            $(this).addClass('activate').html('&raquo;');

            $("#image-back").addClass('disabled')
        }
    });


    $('#disable-image-front').click((function(e) {
        
        e.preventDefault();

        if ($triggerImageFront.attr('disabled')) {

            $triggerImageFront.add($inputImageFront).removeAttr('disabled');

            $('#image-front').removeClass('disabled')


            $(this).removeClass('activate').html('&times;');

        } else {

            $triggerImageFront.attr({disabled: true});
            $inputImageFront.attr({disabled: true})


            $('#image-front').addClass('disabled')

            $(this).addClass('activate').html('&raquo;');
        }

    }));


    var notProcessedKeys = [36, 37, 39];

    $inputCampoChave.keyup(function(e) {
        
        if ($.inArray(e.keyCode, notProcessedKeys) !== -1 || e.ctrlKey || e.shiftKey) {
            return;
        }

        var $self = $(this);
        var value = $self.val();

        var value = value
                        .replace(/\s+/g, '_')
                        .replace(/_+/g, '_')
                        .replace(/[^\w\d-_]+/g, '')
                        .toLowerCase()

        $self.val(value)

    });


    var ajaxRemoveImage = (function(){

        var id = $form.data('id');

        var fixedSettings = {
            url: '/admin/ajax-remover-foto-ficha-tecnica/{0}'.format(id),
            type: 'PUT'
        };


        var func = function (settings) {

            settings = $.extend({}, fixedSettings, settings);

            $.ajax(settings);

        };


        return func;

    })();


    $('#delete-image-back').click(function(e) {
        
        e.preventDefault();

        ajaxRemoveImage({
            data: {foto_verso: true},
            success: function (response) {

                console.log('verso')

                $('#image-back').css({backgroundImage: 'url(/img/no-image.png)'});

            }
        });

    });

    $('#delete-image-front').click(function(e) {
        e.preventDefault();

        ajaxRemoveImage({
            data: {foto_frente: true},
            success: function (response) {

                console.log('frente')
                $('#image-front').css({backgroundImage: 'url(/img/no-image.png)'});
            }
        });
    });

    $('.btn-gerenciar-tecnologias').on('click', function()
    {
        var modal = new wmDialog({
            title: 'Gerenciar Tecnologias',
            btnOkEnabled: false,
            height: 500,
            width: 500
        });

        var tplGerenciarTecnologias = $('#tpl-gerenciar-tecnologias').html();

        modal.html('<img src="/img/loading.gif" width="25" height="25" />', {isHtml: true}).open();

        $.ajax({
            url: '/admin/tipos-cartao',
            type: 'GET',
            dataType: 'json',
            success: function(data)
            {
                var html = _.template(tplGerenciarTecnologias)({tipos: data});
                modal.html(html, {isHtml: true});
                btnDesativar(modal);
                $('#novo-tipo-cartao').on('submit', function(event)
                {
                    var $txtNomeTipo = $('#txt-nome-tipo');
                    var $txtAbreviaturaTipo = $('#txt-abreviatura-tipo');
                    $.ajax({
                        url: '/admin/ajax-cadastrar-tipo-cartao',
                        type: 'PUT',
                        dataType: 'json',
                        data: {
                            nome: $txtNomeTipo.val(),
                            abreviatura: $txtAbreviaturaTipo.val()
                        },
                        success: function(response)
                        {
                            if (response.status) {
                                var tr = _.template($('#tpl-tipo-cadastrado').html())({tipo: response.tipoCartao});
                                $('#tipos-cartao').find('tbody').append(tr);
                            } else {
                                alert(response.error);
                            }
                            btnDesativar(modal);
                        },
                        error: function()
                        {
                            alert('Erro ao processar os dados!')
                        }
                    });
                    return false;
                })
            },
            error: function()
            {
                modal.html('Erro ao processar os dados!')
            }
        });
    });

    $('.btn-gerenciar-entregas').on('click', function()
    {
        var modal = new wmDialog({
            title: 'Gerenciar Entregas',
            btnOkEnabled: false,
            height: 500,
            width: 500
        });

        var tplGerenciarEntregas = $('#tpl-gerenciar-entregas').html();

        modal.html('<img src="/img/loading.gif" width="25" height="25" />', {isHtml: true}).open();

        $.ajax({
            url: '/admin/tipos-entrega',
            type: 'GET',
            dataType: 'json',
            success: function(data)
            {
                var html = _.template(tplGerenciarEntregas)({tipos: data});
                modal.html(html, {isHtml: true});
                btnDesativarEntrega(modal);
                $('#novo-tipo-entrega').on('submit', function(event)
                {
                    var $txtNomeTipo = $('#txt-nome-tipo');
                    $.ajax({
                        url: '/admin/ajax-cadastrar-tipo-entrega',
                        type: 'PUT',
                        dataType: 'json',
                        data: {
                            nome: $txtNomeTipo.val()
                        },
                        success: function(response)
                        {
                            if (response.status) {
                                var tr = _.template($('#tpl-tipo-entrega-cadastrado').html())({tipo: response.tipoEntrega});
                                $('#tipos-entrega').find('tbody').append(tr);
                            } else {
                                alert(response.error);
                            }
                            btnDesativarEntrega(modal);
                        },
                        error: function()
                        {
                            alert('Erro ao processar os dados!')
                        }
                    });
                    return false;
                })
            },
            error: function()
            {
                modal.html('Erro ao processar os dados!')
            }
        });
    });

    function btnDesativar(modal)
    {
        $('.desativar-tipo').on('click', function()
        {
            var $this = $(this);
            $.ajax({
                url: '/admin/ajax-alterar-status-tipo-cartao/' + $this.data('id'),
                type: 'PUT',
                dataType: 'json',
                data: {
                    status: 0
                },
                success: function(response)
                {
                    if (response.error) {
                        modal.html(response.error);
                    } else {
                        $this.closest('tr').fadeOut('slow', function()
                        {
                            $(this).remove();
                        });
                    }
                },
                error: function()
                {
                    modal.html('Erro ao processar.');
                }
            });
        });
    }

    function btnDesativarEntrega(modal)
    {
        $('.desativar-tipo-entrega').on('click', function()
        {
            var $this = $(this);
            $.ajax({
                url: '/admin/ajax-alterar-status-tipo-entrega/' + $this.data('id'),
                type: 'PUT',
                dataType: 'json',
                data: {
                    status: 0
                },
                success: function(response)
                {
                    if (response.error) {
                        modal.html(response.error);
                    } else {
                        $this.closest('tr').fadeOut('slow', function()
                        {
                            $(this).remove();
                        });
                    }
                },
                error: function()
                {
                    modal.html('Erro ao processar.');
                }
            });
        });
    }

});