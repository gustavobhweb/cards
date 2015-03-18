	$(function(){
		var $menuMobile = $('.menu-opened-mobile').css({'transition':'0.4s'});

		$('.btn-menu-mobile').on('click', function(){

            var marginRight = parseInt($menuMobile .css('margin-right'));
            var $containerMenu = $('.container-menu-mobile');

            var isVisible = $menuMobile.data('visible');

            $menuMobile.data('visible', !isVisible);

            if ($(window).width() > 480){

				if (isVisible){

					$menuMobile.css({
						'margin-right': '-311px'

					}).delay(500).queue(function(){

						$containerMenu.css({'z-index':'-1'});

						$(this).dequeue();
					});

				} else {
  
					$menuMobile.css({
						'margin-right': '0px'

					}).queue(function(){
						$containerMenu.css({'z-index':'1'});
						$(this).dequeue();
					});
				}

			} else {

				if (isVisible){

					$menuMobile.css({
						'margin-right': '-100%',

					}).delay(500).queue(function(){

						$containerMenu.css({'z-index':'-1'});

						$(this).dequeue();
					});

				} else {

					$menuMobile.css({
						'margin-right': '0px'

					}).queue(function(){

						$containerMenu.css({'z-index':'1'});

						$(this).dequeue();
					});

				}
			}

		});

	});