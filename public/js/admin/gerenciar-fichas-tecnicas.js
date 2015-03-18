$(function(){
	var $btnDel = $('.btn-del');

	$btnDel.on('click', function()
	{
		var $this = $(this);
		var id = $(this).data('id');
		$.ajax({
			url: '/admin/ajax-deletar-ficha-tecnica',
			type: 'PUT',
			dataType: 'json',
			data: {
				id: id
			},
			success: function(response)
			{
				if (response) {
					$this.parent().parent().fadeOut('slow', function()
					{
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

	$('a.disabled').click(function(e)
	{

		e.preventDefault();
		

	});
});