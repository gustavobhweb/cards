$(function(){
	var $conferir = $('.input-conferir');

	$conferir.on('keyup', function(event){
		if (event.keyCode == 13) {
			var $thisContext = $(this);
			var matricula = $(this).val();
			$.ajax({
				url: '/cliente/ajax-conferir-cartao',
				type: 'POST',
				dataType: 'json',
				data: {
					matricula: matricula
				},
				beforeSend: function()
				{
					$thisContext.val('Aguarde...');
				},
				success: function(response)
				{
					if (response.status) {
						$('tr[data-matricula="' + matricula + '"]').css('background', '#CDE69B');
						$('td[data-matricula="' + matricula + '"').html('<i class="glyphicon glyphicon-ok"></i>');
						$('td[data-matricula="' + matricula + '"').css('color', '#6F9324');
					} else {
						new wmDialog(response.message, {
	                        height:230,
	                        width: 330,
	                        btnCancelEnabled: false
	                    }).open();
					}
					$thisContext.val('');
				},
				error: function()
				{
					alert('Problemas na conexão! Atualize a página e tente novamente.');
					$thisContext.val('');
				}
			});
		}
	});
});