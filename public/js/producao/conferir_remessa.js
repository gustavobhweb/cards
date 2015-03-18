$(function(){

	var $hiddenFile = $('#hidden-excel-file-input'),
		$fakeFileExcel = $("#fake-file-excel");

	$fakeFileExcel.click(function (){
		$hiddenFile.trigger('click');
	});

	$hiddenFile.change(function (){
		$fakeFileExcel.html($(this).val());
	})

});