$.prototype.setContextMenu = function(items)
{
	var $contextMenu = $('<div></div>');
	$contextMenu.attr('id', '#context-menu').addClass('context-menu');
	$contextMenu.html('<ul></ul>');
	$('body').append($contextMenu);
	
	var html = '';
	for (key in items) {
		html += '<li class="clickable-item" onclick="(' + items[key]+ ')()">' + key + '</li>';			
	}
	$contextMenu.find('ul').html(html);
	
	$(this).on('contextmenu', function(event)
	{
		event.preventDefault();
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