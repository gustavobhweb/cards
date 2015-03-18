$(function(){

    $('#select-all').on('click', function(){
        var checked = $('.jtable table input[type="checkbox"]').is(':checked');
        $('.jtable table input[type="checkbox"]').prop('checked', !checked);

        if (!checked) {
            var n = $('.jtable table input[type="checkbox"]:checked').length;
            var btnval = n + ((n > 1) ? ' selecionados' : ' selecionado');
            $(this).html(btnval);
            $(this).removeClass('wm-btn-blue');
            $('.selectable').css('background', '#C1C5FF');
        } else {
            $(this).html("<i class='glyphicon glyphicon-ok'></i> Selecionar todos");
            $(this).addClass('wm-btn-blue');
            $('.selectable').css('background', '');
        }
    });

    $('.btn-reprovar-foto').on('click', function(event){

        event.stopImmediatePropagation();

        var $thisContext = $(this);

        var imageSrc = $('.mini-image[data-id="' + $(this).data('id') + '"]').attr('src');

        var html = '<form data-id="'+ $(this).data('id') +'">';
            html += '<img src="' + imageSrc + '" width="161" height="215" style="float:left" />';
            html += '<p>Você realmente deseja reprovar esta foto?</p><br/>';
            html += '<p>Antes de realizar esta ação digite abaixo o motivo da reprovação:</p>';
            html += '<select class="wm-textarea pull-right slc-motivo" style="width:490px;height:35px;margin:10px 0 0 0">';
                html += '<option>Selecione o motivo...</option>';
                html += '<option>A imagem deve conter o rosto inteiro, pescoço e ombros do solicitante em visão frontal</option>';
                html += '<option>Todas as características faciais devem estar visíveis e desobstruídas</option>';
                html += '<option>Nenhum objeto estranho, outras pessoas, partes do corpo abaixo dos ombros do solicitante, ou outros artefatos</option>';
                html += '<option>A sua foto deve ser recente</option>';
                html += '<option>Somente serão aceitos óculos, onde os olhos são visíveis</option>';
                html += '<option>Chapéus ou corberturas de cabeça não são permitidos</option>';
            html += '</select>';
            html += '<textarea class="wm-textarea pull-right text-obs" style="width:490px;height:106px;margin:10px 0 10px 0" placeholder="Digite aqui as observações, se necessário"></textarea>';

        html += '</form><div class="clearfix"></div>';


        new wmDialog(html, {
            isHTML: true,
            height:345,
            width: 700,
            onConfirm: function($modal)
            {
                var $textObs = $('form[data-id="'+$thisContext.data('id')+'"] .text-obs');
                var $textMotivo = $('form[data-id="'+$thisContext.data('id')+'"] .slc-motivo');

                if ($textMotivo.val() != 'Selecione o motivo...') {
                    var motivo = ($textObs.val() == null || $textObs.val() == '') ? $textMotivo.val() : $textMotivo.val() + ' Obs.: ' + $textObs.val();
                    var data = {
                        solicitacao_id: $thisContext.data('id'),
                        motivo: motivo
                    };

                    $.ajax({
                        url: '/producao/ajax-reprovar-foto',
                        type: 'POST',
                        data: data,
                        dataType: 'json',
                        success: function(response)
                        {
                            if (response.status) {
                                $('.selectable[data-id="'+ data.solicitacao_id +'"]').fadeOut(function(){
                                    $(this).remove();
                                });
                            } else {
                                new wmDialog(response.message, {
                                    height:230,
                                    width: 330,
                                    btnCancelEnabled: false
                                }).open();
                            }
                            $modal.fadeOut();
                        },
                        error: function()
                        {
                            new wmDialog('Problemas de conexão! Atualize a página e tente novamente.', {
                                height:230,
                                width: 330,
                                btnCancelEnabled: false
                            }).open();
                        }
                    });
                } else {
                    $textMotivo.focus();
                    $textMotivo.css({border: '1px solid #f00'});
                }
            }
        }).open();

        $('.text-motivo').on('keyup', function(){
            if ($(this).val().length < 30) {
                $(this).css({border: '1px solid #f00000', boxShadow: '0 0 2px #f00000', transition: '0.8s'});
            } else {
                $(this).css({border: '1px solid #008C23', boxShadow: '0 0 4px #008C23', transition: '0.8s'});
            }
        });
    });

    var html = '<div id="target" style="float:left;margin: 30px 0 30px 200px;height:320px">';
        html += '<img style="margin:0 0 10px 0" id="img-rotate" height="300" />';
    html += '</div>';

    html += "<div id='crop' style='display:none;text-align:center;margin:20px 0 0 140px;float:left;width:320px;'>";
        html += "<div class='jcrop'></div>";
    html += "</div>";

    html += '<div id="group-photo-buttons" style="float:right;margin:30px 0 0 0;width:140px">';
        html += '<button style="width:100%" class="wm-btn wm-btn-blue btn-rotacionar"><i class="glyphicon glyphicon-repeat"></i> Rotacionar</button>';
        html += '<button style="width:100%;margin:5px 0 0 0" class="wm-btn wm-btn-blue btn-ajustar"><i class="glyphicon glyphicon-cog"></i> Ajustar</button>';
    html += '</div>';

    html += '<div id="save-button" style="float:right;display:none;margin:30px 0 0 0;width:140px">';
        html += '<button style="width:100%" class="wm-btn wm-btn-blue save-btn"><i class="glyphicon glyphicon-ok"></i> OK</button>';
        html += '<button style="width:100%;margin:5px 0 0 0" class="wm-btn cancel-btn"><i class="glyphicon glyphicon-remove"></i> Cancelar</button>';
    html += '</div>';

    html += '<div id="save-crop-buttons" style="float:right;display:none;margin:30px 0 0 0;width:140px">';
        html += '<button style="width:100%" class="wm-btn wm-btn-blue save-crop"><i class="glyphicon glyphicon-ok"></i> OK</button>';
        html += '<button style="width:100%;margin:5px 0 0 0" class="wm-btn cancel-crop"><i class="glyphicon glyphicon-remove"></i> Cancelar</button>';
    html += '</div>';

    html += '<div class="clearfix"></div>';

    var dialog = new wmDialog(html, {
        isHTML: true,
        height: 470,
        width: 700,
        title: 'Editar foto',
        btnCancelEnabled: false,
        btnOkEnabled: false
    });

    $('.btn-editar-foto').on('click', function(event){
        event.stopImmediatePropagation();

        var $imgItem = $('.mini-image[data-id="' + $(this).data('id') + '"]');
        var imgsrc = $imgItem.attr('src');

        dialog.open(function(){

            $('#img-rotate').attr('src', imgsrc);

            $('#save-button .save-btn').on('click', function(){
                $.ajax({
                    url: '/producao/ajax-rotacionar',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        imgsrc: imgsrc,
                        angle: (typeof(degAngle) == 'undefined') ? 0 : degAngle
                    },
                    beforeSend: function()
                    {
                        $('#save-button .save-btn').html('Aguarde...');
                    },
                    success: function()
                    {
                        $('#target .ui-rotatable-handle.ui-draggable').hide();
                        $('#save-button').hide(0, function(){
                            $(this).find('.save-btn').html('<i class="glyphicon glyphicon-ok"></i> OK');
                            $('#group-photo-buttons').show(0);
                            $('.btn-ajustar').click();
                        });
                    },
                    error: function()
                    {
                        new wmDialog('Problemas de conexão! Atualize a página e tente novamente.', {
                                height:230,
                                width: 330,
                                btnCancelEnabled: false
                            }).open();
                    }
                });
            });

            $('.btn-ajustar').on('click', function(){
                $('#target').hide();
                $('#crop').show();
                $('#group-photo-buttons').hide(0, function(){
                    $('#save-crop-buttons').show(0);
                });
                $('.jcrop').html('<div class="cropMain"></div><p>Ajustar o zoom:</p><div class="cropSlider"></div>');
                var one = new CROP();
                one.init('.jcrop');
                var imgsrc = $('#target img').attr('src');
                one.loadImg(imgsrc + '?' + new Date().getTime());

                $('.save-crop').on('click', function(){
                    $.ajax({
                        url: '/producao/ajax-crop',
                        type: 'POST',
                        dataType: 'json',
                        data: coordinates(one),
                        beforeSend: function()
                    {
                        $('#save-crop-buttons .save-crop').html('Aguarde...');
                    },
                    success: function(response)
                    {
                        console.log(response);
                        $('#target').show(0, function(){
                            $(this).find('img').attr('src', response.image);
                        });
                        $('#target').css({
                            'transform': '',
                            '-webkit-transform': '',
                            '-moz-transform': '',
                            '-o-transform': '',
                            '-ms-transform': ''
                        });
                        $('#crop').hide();
                        $('#save-crop-buttons').hide(0, function(){
                            $(this).find('.save-crop').html('<i class="glyphicon glyphicon-ok"></i> OK');
                            $('#group-photo-buttons').show(0);
                        });
                        $imgItem.attr('src', response.image)
                        dialog.close();
                    },
                    error: function()
                    {
                        new wmDialog('Problemas de conexão! Atualize a página e tente novamente.', {
                                height:230,
                                width: 330,
                                btnCancelEnabled: false
                            }).open();
                    }
                    });
                });
            });

            $('.cancel-btn').on('click', function(){
                $('#target').css('transform', '');
                $('#target').css('-webkit-transform', '');
                $('#target .ui-rotatable-handle.ui-draggable').hide();
                $('#save-button').hide(0, function(){
                    $('#group-photo-buttons').show(0);
                });
            });

            $('.cancel-crop').on('click', function(){
                $('#save-crop-buttons').hide(0, function(){
                    $('#group-photo-buttons').show(0);
                    $('#crop').hide();
                    $('#target').show();
                });
            });

            $('.btn-rotacionar').on('click', function(){
                $('#group-photo-buttons').hide(0, function(){
                    $('#save-button').show();
                });

                var params = {
                    // Callback fired on rotation start.
                    start: function(event, ui) {
                    },
                    // Callback fired during rotation.
                    rotate: function(event, ui) {
                    },
                    // Callback fired on rotation end.
                    stop: function(event, ui) {
                        window.degAngle = ui.angle.stop * 57.2957795;
                    },
                };

                $('#target').rotatable(params);
                $('#target .ui-rotatable-handle.ui-draggable').show();
            });
        });
    });

    $(".mini-image").on('click', function(e){
        e.stopPropagation();

        var src = $(this).attr('src');

        $('#imageShow')
                .fadeIn()
                .find('img')
                .attr('src', src);
    });

    $("#imageShow").click(function(){
        $(this).fadeOut();
    });

    $(".selectable input[type='checkbox']").on('click', function(event){
        event.stopImmediatePropagation();
    });

    $(".selectable").click(function(event) {
        var $checkbox = $(this).find('[type=checkbox]');
        $checkbox.prop('checked', !$checkbox.is(':checked'));
        if (!$checkbox.is(':checked')) {
            $(this).css('background', '');
        } else {
            $(this).css('background', '#C1C5FF');
        }

        var n = $('.jtable table input[type="checkbox"]:checked').length;

        if (n) {
            var btnval = n + ((n > 1) ? ' selecionados' : ' selecionado');
            $('#select-all').html(btnval);
            $('#select-all').removeClass('wm-btn-blue');
        } else {
            $('#select-all').html("<i class='glyphicon glyphicon-ok'></i> Selecionar todos");
            $('#select-all').addClass('wm-btn-blue');
        }

    }).on('selectstart', function(){
        return false;
    });

    $('.mini-image').tooltip({
        content: function() {
            return "<img width='200' height='267' src='" + $(this).attr('src') + "' />";
        },
        track: true
    });

});