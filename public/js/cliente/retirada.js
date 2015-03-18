$(function(){

	$('#btn-buscar-aluno').on('click', function(){
		$matricula = $('#matricula').val();
		$.ajax({
			url: '/cliente/ajax-buscar-aluno',
			type: 'POST',
			dataType: 'json',
			data: {
				matricula: $matricula
			},
			success: function(response){
				if (response.status) {
					$('.situacao-box').fadeIn();
					$('#-nome').html(response.nome);
					$('#-foto').attr('src', response.foto);
					$('#btn-confirmar-retirada').attr('data-id', response.solicitacao_id);
				} else {
					new wmDialog(response.message, {
                        height:230,
                        width: 330,
                        btnCancelEnabled: false
                    }).open();
				}
			},
			error: function(){
				new wmDialog('Problemas de conexão! Atualize a página e tente novamente.', {
                                height:230,
                                width: 330,
                                btnCancelEnabled: false
                            }).open();
			}
		});
	});

	$('#btn-confirmar-retirada').on('click', function(){
		var $thisContext = $(this);
		confirmar_retirada($(this).data('id'), function(){
			$thisContext.attr('disabled', 'true');
			$thisContext.html('Liberando...');
		}, function(response){
			$thisContext.attr('disabled', 'true');
			$thisContext.removeClass('wm-btn-green');
			$thisContext.html('Liberado');
		});
	});

	$('#btn-confirmar-retirada').on('click', function(){
		var solicitacao_id = $(this).data('id');
	});

	$('#btn-cancelar').on('click', function(){
		$('.situacao-box').fadeOut();
		$('#matricula').val('');
		$('#matricula').focus();
	});

	$('#buscar-aluno').on('submit', function(event){
		$('#btn-buscar-aluno').click();
		return false;
	});

	$('#matricula').focus();

});

function confirmar_retirada(solicitacao_id, beforeSendAction, successAction)
{
	$.ajax({
		url: '/cliente/ajax-confirmar-retirada',
		type: 'POST',
		dataType: 'json',
		data: {
			solicitacao_id: solicitacao_id
		},
		beforeSend: function(){
			if (typeof(beforeSendAction) == 'function') {
				beforeSendAction();
			}
		},
		success: function(response){
			if (!response.status) {
				new wmDialog(response.message, {
                                height:230,
                                width: 330,
                                btnCancelEnabled: false
                            }).open();
			} else if (typeof(successAction) == 'function') {
				successAction(response.message);
				new wmDialog(response.message, {
                            height:230,
                            width: 330,
                            btnCancelEnabled: false
                        }).open();
			}
		},
		error: function(){
			new wmDialog('Problemas de conexão! Atualize a página e tente novamente.', {
                                height:230,
                                width: 330,
                                btnCancelEnabled: false
                            }).open();
		}
	});
}