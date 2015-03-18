$(function(){
	
	$('.clickable').click(function(e) {
		
		var $self = $(this),
			href = $self.find('.link-url').attr('href');

		$(location).prop({href: href});
	});

});