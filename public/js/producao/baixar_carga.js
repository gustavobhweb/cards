$(function() {

    var tabs = {
        noShipping: function() {

            $('#sem-resultados').show().find('td').html(
                'Não há remessas disponíveis para produção');

            return this;

        },

        noTasks: function() {

            $('#sem-resultados').show().find('td').html('Não há tarefas');

            return this;
        },

        elementExists: function(element) {
            return $(element).size();
        }
    };

    $(window).keydown(function(e) {

        if (e.ctrlKey && e.keyCode == 80) {
            e.preventDefault();
            $("#btn-submit, #btn-only-print").trigger('click');
        }
    });

    (function() {
        var blockClick = false,
            username = $('#user-data').data('nome');

        $('.imprimir-remessa')
            .click(
                function(e) {

                    e.preventDefault();

                    if (blockClick)
                        return false;

                    var $self = $(this),
                        $line = $self.closest('tr'),
                        $table = $self
                        .closest('table'),
                        $cell = $self
                        .closest('td');

                    var params = {
                        remessa_id: $(this).data('id')
                    };

                    blockClick = true;

                    $.get(
                        '../producao/ajax-verificar-impressao-protocolo',
                        params,
                        function(response) {

                            if (response.error) {
                                return (new wmDialog(
                                        response.error))
                                    .open();
                            }

                            $line
                                .find('.disabled')
                                .removeClass('disabled');

                            $line
                                .find(
                                    '.responsavel-producao')
                                .html(username);

                            $line
                                .filter('.tab-remessas')
                                .hide()
                                .removeClass('tab-remessas')
                                .addClass('tab-tarefas');

                            if (!$table.find('.tab-remessas').length && $("#btn-tab-remessas").hasClass('active')) {
                                tabs.noShipping();
                            }

                            blockClick = false;

                            $('#only-print-container')
                                .attr({
                                    src: '../producao/imprimir-protocolo/' + params.remessa_id
                                }).load(
                                    function() {
                                    	$(this).prop('contentWindow').print();
                                    });

                        });
                });

    })();

    $('#tabela-baixar-carga').on('click', '.disabled', function(e) {
        e.preventDefault();
    });

    $('.btn-enviar-conferencia').click(function(e) {
            e.preventDefault();

            var $self = $(this);

            var postData = {
                remessa_id: $self.data('id')
            };

            $line = $self.closest('tr'),

                console.log(postData);

            $.post('../producao/ajax-enviar-para-conferencia', postData,
                function(response) {

                    if (response.error) {
                        return (new wmDialog(response.error)).open();
                    }

                    $line.hide(500, function() {
                        return (new wmDialog(response.message)).open();
                    });
                });
        });

    var $table = $("#tabela-baixar-carga"),
        $changeTab = $('.change-tab');

    if (!tabs.elementExists('.tab-remessas')) {
        tabs.noShipping();
    }

    var currentScrollTop = $(window).scrollTop();

    $changeTab.click(function(e)
    {

        e.preventDefault();

        if ($(this).hasClass('active')) {
            return false;
        }

        $changeTab.toggleClass('active');

        var class_show = '.' + $(this).data('target');

        var $tr = $table.find('tbody').find('tr').hide(0);

        var $targetTr = $tr.filter(class_show).show();

        if (!tabs.elementExists($targetTr)) {

            if (class_show == '.tab-tarefas') {
                tabs.noTasks();
            } else {
                tabs.noShipping();
            }
        }
    });

    if ($(location).attr('hash') == '#tab-remessas') {
        $changeTab.trigger('click');
    }

});