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
				comparisonSliderWidth = $(this).width();
				if ($(this).parent().parent().parent().hasClass("vbox-content")) {
					comparisonSliderWidth = $(this).parent().parent().parent().width();
				}
				else {
					comparisonSliderWidth = $(this).width();
				}
				$(this).find(".ce_image").each(function() {
					// var srcToBackground = $(this).find("img").attr("src");
					comparisonSliderRatio = $(this).attr("img-width") / $(this).attr("img-height");
					// var imagePath = 'url(' + srcToBackground + ')';
					// $(this).find(".image_container").css("display", "none");
					// $(this).css("background-image", imagePath);
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
		        $(this).css("background-color", "#6cbb48");
		    });

		    $('.comparison-slider').tapend(function() {
		        comparisonSliderClicked = false;
		        $('.comparison-slider .drag-button').css("background-color", "");
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

