(function($) {
	var comparisonSliderWidth;
	var comparisonSliderRatio;
	var comparisonSliderClicked;

	function initComparisonSlider() {
		
		var comparisonSliderClicked = false;
			
		if ($(".ce_comparison-slider ").length > 0) {
			$('.ce_comparison-slider ').each(function() {

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

				$(this).find(".comparison-slider-text").css("width", comparisonSliderWidth/2);
			});

			$('.ce_comparison-slider  .drag-button').tapstart(function() {
		        comparisonSliderClicked = true;
		        $(this).addClass("dragged");
		    });

		    $('.ce_comparison-slider ').tapend(function() {
		        comparisonSliderClicked = false;
		        $(this).find(".drag-button").removeClass("dragged");
		    });

		    $('.ce_comparison-slider ').tapmove(function(e, touch) {
		        if (comparisonSliderClicked === false) {
		            return;
		        }
				

		        $(this).find(".ce_image:first-child").css("width", touch.offset.x);

				$(this).find(".ce_image:last-child").css("width", parseInt(comparisonSliderWidth) - touch.offset.x);
				
		    });

		}

	}

	$(window).on('load', function() {
		initComparisonSlider();
	});

	$(window).on('resize', function() {
		initComparisonSlider();
	});

})(jQuery);

