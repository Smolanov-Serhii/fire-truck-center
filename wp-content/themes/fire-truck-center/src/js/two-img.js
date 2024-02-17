$(function () {
	"use strict";
	$('.comparison').each(function () {

		$(this).find('img:first').wrap("<div class='before'></div>");
		$(this).find('img:last').wrap("<div class='after'></div>");
		$(this).append("<div class='hand'></div>");

		var edge = $(this).attr('data-edge');
		if (typeof edge !== 'undefined') {
			$(this).find('.before').css('width', edge + '%');
			$(this).find('.hand').css('left', edge + '%');
		} else {
			$(this).find('.before').css('width', '50%');
			$(this).find('.hand').css('left', '50%');
		}

		var slideResize = function (e) {
			e.preventDefault();
			var $width = $(this).width();
			var pageX = (e.pageX - e.currentTarget.offsetLeft) / $width * 100;
			$(this).find('.before').css('width', pageX + '%');
			$(this).find('.hand').css('left', pageX + '%');
		}

		var enableSliderDrag = function (e) {
			e.preventDefault();
			$(this).css('cursor', 'ew-resize').on('mousemove', slideResize);
		}

		var disableSliderDrag = function (e) {
			e.preventDefault();
			$(this).css('cursor', 'normal').off('mousemove');
		}

		$(this).on("mousedown", enableSliderDrag);
		$(this).on("mouseup", disableSliderDrag);
		$(this).on('touchmove', function (e) {
			e.preventDefault();
			var touch = e.originalEvent.touches[0];
			var $width = $(this).width();
			var pageX = (touch.pageX - e.currentTarget.offsetLeft) / $width * 100;
			$(this).find('.before').css('width', pageX + '%');
			$(this).find('.hand').css('left', pageX + '%');
		});

	});
});

function getsize() {
	$('.comparison').each(function () {
		var $width = $(this).width();
		$(this).find('img').css('width', $width + 'px');
	});
}

$(window).resize(getsize).resize();
$(window).on('resize', getsize);
$(window).on('load', getsize);
$(window).on("orientationchange", getsize);