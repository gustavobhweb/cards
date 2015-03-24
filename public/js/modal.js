function Modal()
{
	this.opened;
	var modalContext = this;
	this.alert = function(text)
	{
		var $total = $('<div></div>');
		$total.addClass('modal');
		$('body').append($total);
		$total.animate({
			width: '100%',
			height: '100%',
			left: 0,
			top: 0,
			opacity: 1
		}, 400, function()
		{

		});

		this.opened = $total;

		var $box = $('<div></div>');
		$box.addClass('box-modal');
		$total.append($box);

		var $title = $('<div></div>');
		$title.addClass('title');
		$title.append('<p class="left"><i class="halflings halflings-warning-sign"></i> Atenção!</p>');
		$title.append('<button class="btn right close"><i class="halflings halflings-remove"></i></button>');
		$box.append($title);

		$('.close').on('click', function()
		{
			modalContext.close();
		})

		$box.animate({
			top: '35%'
		}, 800, function()
		{

		})

		$box.draggable({
			handle: '.title',
			cursor: 'move'
		});
	}

	this.confirm = function()
	{

	}

	this.close = function()
	{
		this.opened.animate({
			width: '95%',
			height: '95%',
			left: '2.5%',
			top: '2.5%',
			opacity: 0
		}, function()
		{
			$(this).remove();
		});
	}
}