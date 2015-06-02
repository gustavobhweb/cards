$(function()
{
	$btnSolicitar2via = $('.btn-solicitar-2-via');

	$btnSolicitar2via.on('click', function()
	{
		var solicitacao_id = $(this).data('id');
		var $this = $(this);

		$.ajax({
			url: 'cliente/solicitacao-segunda-via',
			type: 'POST',
			dataType: 'json',
			data: {
				solicitacao_id: solicitacao_id
			},
			beforeSend: function()
			{
				$this.html('Solicitando...');
			},
			success: function(response)
			{
				if (response.status) {
					$this.removeClass('blue')
						 .addClass('green')
						 .val('<i class="halflings halflings-ok"></i>');
				} else {
					$this.removeClass('green')
						 .addClass('blue')
						 .val('Solicitar 2ª via');
				}
			},
			error: function()
			{
				$this.removeClass('green')
						 .addClass('blue')
						 .val('Solicitar 2ª via');
				alert('Verifique sua conexão com a internet.');
			}
		});
	});
});