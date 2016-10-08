;(function($) {
	$(function() {
		$('.popup').bind('click', function(e) {
			var link = $(this).attr('href')
			var wrap = $('.popupWrap');
			e.preventDefault();
			$('#wrapper').addClass('fixed');
			$('#popupBack').show();
			$('#popup').show();
			wrap.load(link || '');
		});
		$('.popupClose, #popupBack').bind('click', function(e) {
			var wrap = $('.popupWrap');
			wrap.empty();
			$('#wrapper').removeClass('fixed');
			$('#popupBack').hide();
			$('#popup').hide();
		});
		$(document).keyup(function(e) {
		  if (e.keyCode == 27) { 
			var wrap = $('.popupWrap');
			wrap.empty();
			$('#wrapper').removeClass('fixed');
			$('#popupBack').hide();
			$('#popup').hide();
			}
		});
		
		$('.subTab').bind('click', function(e) {
			$(this).addClass('on').siblings().removeClass('on');
			$(this).next('.content').addClass('on').siblings().next('content').removeClass('on') ;
		});
	});

 })(jQuery);