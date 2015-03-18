$(function(){
	$('.user').draggable({
		revert: "valid",
		revertDuration: 0
	});
	$( ".section-nivel" ).droppable({
     	hoverClass: "hoverDrag",
     	activeClass: "custom-state-active",
      	drop: function( event, ui ) {
      		$(this).find('.users').append(ui.draggable);
      		var data = {
      			usuario_id: ui.draggable.data('id'),
      			nivel_id: $($(this)[0]).data('id')
			}
			$.ajax({
				url: 'admin/ajax-trocar-nivel',
				type: 'POST',
				dataType: 'json',
				data: data,
				error: function(){
					alert('Problemas de conexão!');
				}
			});
      	}
    });
});