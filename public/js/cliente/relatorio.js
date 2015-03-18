$(function(){
	$('.mini-image').tooltip({
        content: function() {
            return "<img width='200' height='267' src='" + $(this).attr('src') + "' />";
        },
        track: true
    });
});