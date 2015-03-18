$(function(){

    var tpl = $('#tpl-more-info').html();

    $('.show-info').click(function() {
        var object = {
            usuario: $(this).data('object'),
            imagePath: $(this).data('image-path')
        };

        var html = _.template(tpl).call(null, object);


        var dialog = new wmDialog(html, {isHTML:true, height: 'auto', btnCancelEnabled: false});

        dialog.open();
    });


    $('#selecionar-filtro').change(function() {
        var value = $(this).val(),
            $input = $('#pesquisa-input');


        $input.attr('class', 'wm-input input-large');

        if ($input.data('ui-autocomplete') != undefined) {
            $input.autocomplete('destroy');
        }


        if (value === 'usuarios.cpf') {

            $input.addClass('cpf-mask');

        } else if (value === 'instituicoes.nome') {

            $input.val('');
            
            $.get('/cliente/ajax-listar-instituicoes/', {}, function(response){
                 $input.autocomplete({
                     source: response
                 });
            });

        } else if (value == 's_remessa.remessa_id') {

            $input.addClass('autocomplete-remessa').val('');

            $.get('/cliente/ajax-listar-remessas', {}, function(response){
                $input.autocomplete({
                    source: response
                });
            });
        }


    });


});