// ts-check
function initComparisonSliders() {
    let comparisonSliders = document.querySelectorAll('.ce_comparison-slider');

    function buildSlider(slider) {
        let comparisonSliderWidth;
        let comparisonSliderRatio;
        let comparisonSliderClicked = false;

        let firstImage = slider.querySelector('.image_container:first-child');
        let secondImage = slider.querySelector('.image_container:last-child');
        let dragButton = document.createElement('div');
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
        secondImage.style.width = '';

        // $(this)
        //     .find('.comparison-slider-text')
        //     .style.width = comparisonSliderWidth / 2);

        function enableSliding() {
            comparisonSliderClicked = true;
            slider.classList.add('dragged');
        }

        function disableSliding() {
            comparisonSliderClicked = false;
            dragButton.classList.remove('dragged');
        }

        dragButton.addEventListener('mousedown', enableSliding);
        dragButton.addEventListener('touchstart', enableSliding);

        slider.addEventListener('mouseup', disableSliding);
        slider.addEventListener('touchend', disableSliding);

        slider.addEventListener('mousemove', function (e) {
            if (comparisonSliderClicked === false) {
                return;
            }
            const rect = slider.getBoundingClientRect();
            const offsetX = e.clientX - rect.left;
            if (offsetX <= 0 || offsetX >= comparisonSliderWidth) return;

            firstImage.style.width = offsetX + 'px';
            secondImage.style.width = parseInt(comparisonSliderWidth) - offsetX + 'px';
        });

        slider.addEventListener('touchmove', function (e) {
            if (comparisonSliderClicked === false) {
                return;
            }
            const rect = slider.getBoundingClientRect();
            const offsetX = e.touches[0].clientX - rect.left;
            if (offsetX <= 0 || offsetX >= comparisonSliderWidth) return;

            firstImage.style.width = offsetX + 'px';
            secondImage.style.width = parseInt(comparisonSliderWidth) - offsetX + 'px';
        });
    }

    comparisonSliders.forEach((slider) => buildSlider(slider));
}

window.addEventListener('DOMContentLoaded', initComparisonSliders);
window.addEventListener('resize', initComparisonSliders);
