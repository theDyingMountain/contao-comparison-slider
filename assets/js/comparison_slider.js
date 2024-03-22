function initComparisonSliders() {
    let comparisonSliders = document.querySelectorAll('.ce_comparison-slider');

    function buildSlider(slider) {
        let comparisonSliderWidth;
        let comparisonSliderRatio;
        let comparisonSliderClicked = false;

        let firstImage = slider.querySelector('.image_container:first-child');
        let secondImage = slider.querySelector('.image_container:last-child');
        let dragButton = slider.querySelector('.drag-button') || document.createElement('div');
        dragButton.classList.add('drag-button');

        slider.querySelector('.image_container:first-child').appendChild(dragButton);

        let vbox = slider.closest('.vbox-content');

        if (vbox) {
            comparisonSliderWidth = vbox.getBoundingClientRect().width;
        } else {
            comparisonSliderWidth = slider.getBoundingClientRect().width;
        }

        comparisonSliderRatio =
            firstImage.querySelector('img').naturalHeight / firstImage.querySelector('img').naturalWidth;

        slider.style.height = comparisonSliderWidth * comparisonSliderRatio + 'px';
        firstImage.style.width = '';
        firstImage.style.maxWitdh = comparisonSliderWidth + 'px';
        secondImage.style.maxWitdh = comparisonSliderWidth + 'px';
        secondImage.style.width = '';

        function enableSliding() {
            comparisonSliderClicked = true;
            slider.classList.add('dragged');
        }

        function disableSliding() {
            comparisonSliderClicked = false;
            slider.classList.remove('dragged');
        }

        function applyWidth(offsetX) {
            if (offsetX - 2 <= 0) {
                firstImage.style.width = 0 + 'px';
                secondImage.style.width = parseInt(comparisonSliderWidth) + 'px';
            } else if (offsetX + 2 >= comparisonSliderWidth) {
                firstImage.style.width = parseInt(comparisonSliderWidth) + 'px';
                secondImage.style.width = 0 + 'px';
            } else {
                firstImage.style.width = offsetX + 'px';
                secondImage.style.width =
                    parseInt(comparisonSliderWidth) - Math.min(offsetX, comparisonSliderWidth) + 'px';
            }
        }

        function handleMouseSliding(e) {
            if (comparisonSliderClicked === false) {
                return;
            }
            const rect = slider.getBoundingClientRect();
            const offsetX = e.clientX - rect.left;
            applyWidth(offsetX);
        }

        function handleTouchSliding(e) {
            if (comparisonSliderClicked === false) {
                return;
            }
            const rect = slider.getBoundingClientRect();
            const offsetX = e.touches[0].clientX - rect.left;
            applyWidth(offsetX);
        }

        dragButton.onmousedown = enableSliding;
        dragButton.ontouchstart = enableSliding;
        dragButton.onmouseup = disableSliding;

        slider.onmouseup = disableSliding;
        slider.ontouchend = disableSliding;
        slider.onmouseleave = handleMouseSliding;
        window.addEventListener('mouseup', disableSliding);

        slider.onmousemove = handleMouseSliding;
        slider.ontouchmove = handleTouchSliding;
    }

    comparisonSliders.forEach((slider) => buildSlider(slider));
}

window.addEventListener('load', initComparisonSliders);
window.addEventListener('DOMContentLoaded', initComparisonSliders);
window.addEventListener('resize', initComparisonSliders);
