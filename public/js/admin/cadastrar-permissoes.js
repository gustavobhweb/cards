$(function(){
	var $inputAction = $('#input-action');
	var timeout;
	$inputAction.on('keyup', function(){
		clearTimeout(timeout);
		var thisContext = $(this);
		timeout = setTimeout(function(){
			$('.box-search-action').fadeIn();
			$('.box-search-action').html('<img width="15px" height="15px" src="../img/loading.GIF" />');
			$.ajax({
				url: '/admin/ajax-search-methods',
				type: 'GET',
				dataType: 'json',
				data: {
					search: thisContext.val()
				},
				success: function(response)
				{
					if (response.length) {
						var html = '';
						for (i in response) {
							html += '<div class="item">' + response[i] + '</div>';
						}
						$('.box-search-action').html(html);
						$('.box-search-action .item').on('click', function(){
							makeUrl($(this).html());
							$inputAction.val($(this).html()).focus();
							$('.box-search-action').fadeOut('slow', function(){
								$(this).html('');
							});
						});
					} else {
						$('.box-search-action').fadeOut('slow', function(){
							$(this).html('');
						});
					}
				},
				error: function()
				{
					$('.box-search-action').fadeOut('slow', function(){
						$(this).html('');
					});
				}
			});
		}, 500);
	});
	$inputAction.on('blur', function(){
		makeUrl($(this).val());
	});
});

function makeUrl(action)
{
	$.ajax({
		url: '/admin/ajax-make-url',
		type: 'GET',
		dataType: 'json',
		data: {
			action: action
		},
		success: function(response)
		{
			$('#input-url').val(response.url);
			$('#select-type').val(response.type);
		}
	});
}