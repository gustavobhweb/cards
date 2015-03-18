$(function(){

	var $btnRestaurar = $('.btn-restaurar');

	$btnRestaurar.on('click', function() {

		var id = $(this).data('id');
		var $this = $(this);

		$.ajax({
			url: '/admin/ajax-restaurar-ficha-tecnica',
			type: 'PUT',
			dataType: 'json',
			data: {
				id: id
			},
			success: function(response) {
				if (response) {
					$this.closest('tr').fadeOut('slow', function() {
						$(this).remove();
					});
				}
			},
			error: function()
			{
				console.error('Problemas na conexão!');
			}
		});
	});


	var $btnInfo = $('.btn-info');

	var modalInfo = new wmDialog({height: 350});

	var tplInfo = $('#tpl-info').html()


	$btnInfo.on('click', function() {

		var $self = $(this),
			id    = $self.data('id');

			$.ajax({

				url: '/admin/info-lixeira-ficha-tecnica/' + id,
				type: 'GET',
				success: function(response) {

					var html = _.template(tplInfo)({ficha: response});

					modalInfo.html(html, true).open()

				}
			});

	});
});