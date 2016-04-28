(function($) {
	var comparisonSliderWidth;
	var comparisonSliderRatio;
	var comparisonSliderClicked;
	var comparisonSliderPositionX;
	var mousePositionX;

	function initComparisonSlider() {
		
		var comparisonSliderClicked = false;
			
		if ($(".comparison-slider").length > 0) {
			$('.comparison-slider').each(function() {

				if ($(this).parents().hasClass("vbox-content")) {
					comparisonSliderWidth = $(this).parents(".vbox-content").width();
				}
				else {
					comparisonSliderWidth = $(this).width();
				}

				$(this).find(".ce_image").each(function() {
					comparisonSliderRatio = $(this).attr("img-width") / $(this).attr("img-height");
					$(this).css("height", comparisonSliderWidth / comparisonSliderRatio);
				});
				
				$(this).css("height", comparisonSliderWidth / comparisonSliderRatio);
				$(this).find(".ce_image:first-child").css("width", "");
				$(this).find(".ce_image:first-child").css("max-width", comparisonSliderWidth);
				$(this).find(".ce_image:last-child").css("width", "");
				$(this).find(".drag-button").remove();
				$(this).find(".ce_image:first-child").append('<div class="drag-button"></div>');
			});
		
			$('.comparison-slider .drag-button').tapstart(function() {
		        comparisonSliderClicked = true;
		        $(this).addClass("dragged");
		    });

		    $('.comparison-slider').tapend(function() {
		        comparisonSliderClicked = false;
		        $(this).find(".drag-button").removeClass("dragged");
		    });

		    $('.comparison-slider').tapmove(function(e, touch) {
		        if (comparisonSliderClicked === false) {
		            return;
		        }
				comparisonSliderPosition=$(this).offset();
				mousePositionX = touch.position.x-comparisonSliderPosition.left;
				
		        $(this).find(".ce_image:first-child").css("width", mousePositionX);
				$(this).find(".ce_image:last-child").css("width", parseInt(comparisonSliderWidth) - mousePositionX);
				
		    });

		}

	}

	$(document).ready(function() {
		initComparisonSlider();
	});

	$(window).resize(function() {
		initComparisonSlider();
	});

})(jQuery);

