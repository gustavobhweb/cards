$(function(){

	var $btnZip = $('.fake-file-zip'),
		$inputFile = $('.file-zip-upload');

	$btnZip.data('default_html', $btnZip.html());

	$btnZip.click(function(){
		var $self = $(this);
		var $container = $self.closest('.container-input-file');
		var $inputFile = $container.find('.file-zip-upload');

		console.log($inputFile.length);
		$inputFile.trigger('click');
	});


	var modal = new wmDialog({btnCancelEnabled: true});

	var tplMessage = $("#tpl-msg").html();


	$inputFile.change(function(e){

		e.preventDefault();

		var $self = $(this);

		var $container = $self.closest('.container-input-file');

		var $tr = $self.closest('tr');

		var countTotal = parseInt($tr.find('.count-total').html());

		var $countIncompletes = $tr.find('.count-incompletes');

		var countIncompletes = parseInt($countIncompletes.html())

		var $btnZip = $container.find('.fake-file-zip');

		var filename = $self.val().split('\\').pop();

		if (! filename.match(/\.zip$/gi)) {

			var message = "Extensão de arquivo inválida. Somente ZIP é aceito!";

			modal.html(message).open()

			return false;

		}

		$btnZip.html(filename);

		var files = $self.prop('files')[0];

		var formData = new FormData;

		formData.append('zip', files);

		var id = $container.data('id');

		$.ajax({
			url: '/cliente/ajax-upload-zip/' + id,
			type: 'POST',
			error: function(){

				modal.html('Erro ao processar o pedido').open()
			},
			success: function(response) {

				if (response.error) {
					modal.html(response.error).open()
				} else {
					var message = _.template(tplMessage)({data: response});
					if (!response.missing_photos) {
						$tr.fadeOut('slow', function()
						{
							var countEnviarFoto = parseInt($('#enviar-foto-count').html());
							var countImpressao = parseInt($('#impressao-count').html());
							$('#enviar-foto-count').html(countEnviarFoto - 1);
							$('#impressao-count').html(countImpressao + 1);
							if (!(countEnviarFoto - 1)) {
								var htmlContentRemessas = '<div class="j-alert-error">';
								htmlContentRemessas += 'Não há remessas para o envio de fotos';
								htmlContentRemessas += '</div>';
								$('.content-remessas').html(htmlContentRemessas);
							}
							$(this).remove();
						});
						clickSendPrint();
					}
					$('.progress-desc[data-id="'+id+'"]').html((countTotal - response.missing_photos) + '/' + countTotal);
					$('.progress-bar[data-id="'+id+'"]').attr('value', countTotal - response.missing_photos);
					modal.html(message, true).open();
				}

				$self.val('');
				
				$btnZip.html($btnZip.data('default_html'));

			},
			processData: false,
			cache: false,
			contentType: false,
			data: formData
		})


	});


	var modalMoreInfo = new wmDialog({height: 'auto'});

	var tplMoreInfo = $('#tpl-more-info').html();


	$('.btn-info').click(function(e) {
		
		e.preventDefault();

		var id = $(this).val();

		$.ajax({

			url: '/cliente/ajax-solicitacoes-pendentes/' + id,
			type: 'GET',

			success: function ( response ) {
				var html = _.template(tplMoreInfo)({solicitacoes: response});
				modalMoreInfo.html(html, true).title('Remessa - ' + id).open();
			},
			error: function (){
				modalMoreInfo.html('Erro ao processar os dados').open();
			}
		})
	});

	clickSendPrint();

});
function clickSendPrint()
{
	$('.send-print').on('click', function()
	{
		var modal = new wmDialog({height: 'auto'});
		var remessa_id = $(this).parent().attr('data-id');
		var $tr = $(this).closest('tr');
		$.ajax({
			url: '/cliente/ajax-solicitar-impressao',
			type: 'POST',
			dataType: 'json',
			data: {
				remessa_id: remessa_id
			},
			success: function(response)
			{
				if (!response.status) {
					modal.html(response.message).open();
				} else {
					modal.html('A remessa foi enviada para produção com sucesso!').open();
					$tr.fadeOut('slow', function()
					{
						var countImpressao = parseInt($('#impressao-count').html());
						var countHistorico = parseInt($('#historico-count').html());
						$('#impressao-count').html(countImpressao - 1);
						$('#historico-count').html(countHistorico + 1);
						if (!(countImpressao - 1)) {
							var htmlContentRemessas = '<div class="j-alert-error">';
							htmlContentRemessas += 'Não há remessas para solicitar impressão';
							htmlContentRemessas += '</div>';
							$('.content-remessas').html(htmlContentRemessas)
						}
						$(this).remove();
					});
				}
			},
			error: function()
			{
				modal.html('Problemas na conexão! Atualize a página e tente novamente.').open();
			}
		});
	});
}