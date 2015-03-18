$(function(){

	var modalAlert = new wmDialog();

	$('.btn-liberar-remessa').on('click', function(){

		var $self = $(this);

		var remessa_id = $self.data('id')


		$.ajax({
			url: '/financeiro/ajax-liberar',
			type: 'POST',
			dataType: 'json',
			data: {
				remessa_id: remessa_id
			},
			beforeSend: function(){
				$self.attr({disabled: true}).html('Liberando...');
			},
			success: function(response){

				if (response.error) {

					modalAlert
						.html(response.error)
						.attr({height : 230, width: 330, btnCancelEnabled: false})
                        .open();

				} else {

					$self.attr({disabled: false}).removeClass('wm-btn-green').html('Liberado');
				}

			},
			error: function(){

				var msg = 'Problemas de conexão! Atualize a página e tente novamente.';

				modalAlert
					.html(msg)
					.attr({height: 230, width: 330, btnCancelEnabled: false})
                    .open();
			}
		});
	});

});