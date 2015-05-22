$(function(){

	var $btnZip = $('.fake-file-zip'),
		$inputFile = $('#file-upload');

	$btnZip.data('default_html', $btnZip.html());

	$btnZip.click(function(){
		$('#remessa_id').val($(this).data('remessa'));
		$('#send-photos').attr('action', '/cliente/ajax-upload-zip/' + $(this).data('remessa'))
		$inputFile.trigger('click');
	});


	var modal = new wmDialog({btnCancelEnabled: true});

	var tplMessage = $("#tpl-msg").html();


	$inputFile.change(function(e){

		e.preventDefault();

		var $self = $(this);

		$('#send-btn').click();

		// var $container = $self.closest('.container-input-file');

		// var $tr = $self.closest('tr');

		// var countTotal = parseInt($tr.find('.count-total').html());

		// var $countIncompletes = $tr.find('.count-incompletes');

		// var countIncompletes = parseInt($countIncompletes.html())

		// var $btnZip = $container.find('.fake-file-zip');

		// var filename = $self.val().split('\\').pop();

		// if (! filename.match(/\.zip\.rar\.mp4$/gi)) {

		// 	var message = "Extensão de arquivo inválida. Somente ZIP é aceito!";

		// 	modal.html(message).open()

		// 	return false;

		// }

		// $btnZip.html(filename);

		// var files = $self.prop('files')[0];

		// var formData = new FormData;

		// formData.append('zip', files);

		// var id = $container.data('id');

		// $.ajax({
		// 	url: '/cliente/ajax-upload-zip/' + id,
		// 	type: 'POST',
		// 	error: function(){

		// 		modal.html('Erro ao processar o pedido').open()
		// 	},
		// 	success: function(response) {

		// 		if (response.error) {
		// 			modal.html(response.error).open()
		// 		} else {
		// 			var message = _.template(tplMessage)({data: response});
		// 			if (!response.missing_photos) {
		// 				$tr.fadeOut('slow', function()
		// 				{
		// 					var countEnviarFoto = parseInt($('#enviar-foto-count').html());
		// 					var countImpressao = parseInt($('#impressao-count').html());
		// 					$('#enviar-foto-count').html(countEnviarFoto - 1);
		// 					$('#impressao-count').html(countImpressao + 1);
		// 					if (!(countEnviarFoto - 1)) {
		// 						var htmlContentRemessas = '<div class="j-alert-error">';
		// 						htmlContentRemessas += 'Não há remessas para o envio de fotos';
		// 						htmlContentRemessas += '</div>';
		// 						$('.content-remessas').html(htmlContentRemessas);
		// 					}
		// 					$(this).remove();
		// 				});
		// 				clickSendPrint();
		// 			}
		// 			$('.progress-desc[data-id="'+id+'"]').html((countTotal - response.missing_photos) + '/' + countTotal);
		// 			$('.progress-bar[data-id="'+id+'"]').attr('value', countTotal - response.missing_photos);
		// 			modal.html(message, true).open();
		// 		}

		// 		$self.val('');
				
		// 		$btnZip.html($btnZip.data('default_html'));

		// 	},
		// 	processData: false,
		// 	cache: false,
		// 	contentType: false,
		// 	data: formData
		// })


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
	uploader();

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

function uploader(){
        
    var bar = $('.bar');
    var percent = $('.percent');
    var status = $('.status');
    var loading = $('.loading');
       
    $('#send-photos').ajaxForm({
        beforeSend: function() {
            var remessa_id = $('#remessa_id').val();

            status.filter('[data-remessa="'+remessa_id+'"]').empty();
            var percentVal = '0%';
            bar.filter('[data-remessa="'+remessa_id+'"]').width(percentVal)
            percent.filter('[data-remessa="'+remessa_id+'"]').html(percentVal);
            loading.filter('[data-remessa="'+remessa_id+'"]').show();
        },
        uploadProgress: function(event, position, total, percentComplete) {
            var remessa_id = $('#remessa_id').val();

            var percentVal = percentComplete + '%';
            bar.filter('[data-remessa="'+remessa_id+'"]').width(percentVal)
            percent.filter('[data-remessa="'+remessa_id+'"]').html(percentVal);
        },
        success: function() {
            var remessa_id = $('#remessa_id').val();

            var percentVal = '100%';
            bar.filter('[data-remessa="'+remessa_id+'"]').width(percentVal)
            percent.filter('[data-remessa="'+remessa_id+'"]').html(percentVal);
        },
        error: function(){
        	var remessa_id = $('#remessa_id').val();

        	status.filter('[data-remessa="'+remessa_id+'"]').fadeIn();
			status.filter('[data-remessa="'+remessa_id+'"]').removeClass('success').html('Verifique sua conexão com a Internet!');
        },
        complete: function(xhr) {
            var remessa_id = $('#remessa_id').val();
        	var $tr = $('.container-input-file').filter('[data-id="'+remessa_id+'"]').closest('tr');
            var countTotal = parseInt($tr.find('.count-total').html());
            var $inputFile = $('#file-upload');
            var $btnZip = $('.fake-file-zip')

            loading.filter('[data-remessa="'+remessa_id+'"]').hide();
            status.filter('[data-remessa="'+remessa_id+'"]').fadeIn();
            
            if (xhr.responseJSON.error) {
				status.filter('[data-remessa="'+remessa_id+'"]').removeClass('success').html(xhr.responseJSON.error);
			} else {
				if (!xhr.responseJSON.missing_photos) {
					$tr.fadeOut('slow', function()
					{
						var countEnviarFoto = $('tbody tr').length;
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
				$('.progress-desc[data-id="'+remessa_id+'"]').html((countTotal - xhr.responseJSON.missing_photos) + '/' + countTotal);
				$('.progress-bar[data-id="'+remessa_id+'"]').attr('value', countTotal - xhr.responseJSON.missing_photos);
				status.filter('[data-remessa="'+remessa_id+'"]').addClass('success').html();
			}

			$inputFile.val('');
			
			$btnZip.html($btnZip.data('default_html'));
        }
    }); 

}