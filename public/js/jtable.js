$(function(){
	$('#slc-limit').on('change', function(){
	    window.location.href = '?' + $(this).val();
	});

	$('#slc-limit option').each(function(){
		if ((getParameterByName('limit') == null || getParameterByName('limit') == '') && $(this).data('limit') == 10) {
			$(this).attr('selected', 'selected');
		} else if ($(this).data('limit') == parseInt(getParameterByName('limit'))) {
	        $(this).attr('selected', 'selected');
	    }
	});
});

function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
        results = regex.exec(location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}