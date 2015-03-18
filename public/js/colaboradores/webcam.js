$(function(){

	/*!
		Escopo das variáveis
	*/

	var $userPhoto = $('.userPhoto');

	var usuarioId = $userPhoto.data('id');





	new ImgSelect( $('#imgselect_container'), {
		url: '/colaboradores/snapwebcam',
	} );

	var getUserMedia = !!(navigator.getUserMedia || navigator.webkitGetUserMedia || 
                            navigator.mozGetUserMedia || navigator.msGetUserMedia);

	$('#btn-take-photo').click(function(){

		$('#enviar-foto').fadeOut(function(){

			if (getUserMedia) {
				$('#webcam').show(0, function(){
					$('.imgs-webcam').click();
	                $('#imgselect_container').fadeOut();
	                $('#waitcam').fadeIn();
	                $('#avisopermitir').fadeIn();
				});

			} else {

				$('#flashcam').show(0, function(){
					$("#flashbox").scriptcam({
	                    showMicrophoneErrors:false,
	                    onError:function(){},
	                    cornerRadius:20,
	                    disableHardwareAcceleration:1,
	                    cornerColor:'e3e5e2',
	                    onWebcamReady:function(){
	                    	$('#btns-flash').fadeIn();
	                    	$('.normalize-border').show();
	                    },
	                    onPictureAsBase64:function(){},
	                    path: '/'
                	});
				});

			}
		});
	});
 
	$('.btn-capture-flash').on('click', function(){
		$.ajax({
			url: '/aluno/snapwebcam',
			type: 'POST',
			dataType: 'json',
			data: {
				file: $.scriptcam.getFrameAsBase64(),
				flash: true
			},
			success: function(){
				$('.modal-photo').fadeOut();
			    $('.return-modal-menu').click();

			    $('.userPhoto').attr({
			    	'src' : '/imagens/' + usuarioId  + '/temp.png' + '?' + $.now(),
			    	'data-selected' : 'true'
			    });
			},
			error: function(){
				new wmDialog('Problemas na conexão! Atualize a página e tente novamente.', {
	                height:230,
	                width: 330,
	                btnCancelEnabled: false
	            }).open();
			}
		});
	});

});