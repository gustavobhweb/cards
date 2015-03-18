$(function(){
	var $btnChangeMail = $('#btn-edit-mail-of-solicitation');
	var $boxEditMail = $('#box-edit-mail-of-solicitation');
	var $statusContent = $('.status-list .content');

	$btnChangeMail.click(function(){
		if(!$boxEditMail.is(':visible')){
			$boxEditMail.fadeIn();
		} else {
			$boxEditMail.fadeOut();
		}
	});
});