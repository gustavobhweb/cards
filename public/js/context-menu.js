$.prototype.setContextMenu = function(items)
{
	var $contextMenu = '';
	if (!$('.context-menu').length) {
		$contextMenu = $('<div></div>');
		$contextMenu.addClass('context-menu');
		$contextMenu.html('<ul></ul>');
		$('body').append($contextMenu);
	} else {
		$contextMenu = $('.context-menu');
	}
		
	$(this).on('contextmenu', function(event)
	{
		event.preventDefault();
		event.stopPropagation();
		var html = '';
		console.log(items);
		for (key in items) {
			html += '<li class="clickable-item" onclick="(' + items[key]+ ')()">' + key + '</li>';			
		}
		$contextMenu.find('ul').html(html);
		var left = event.clientX,
			top = event.clientY;
		
		$contextMenu.fadeIn().css({
			left: left,
			top: top
		});
		
	});
	$(window).on('click', function()
	{
		$contextMenu.fadeOut();
	});
	$contextMenu.on('click', function(event)
	{
		event.stopPropagation();
	});
	
	return $(this);
}