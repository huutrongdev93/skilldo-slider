<script>
    document.querySelectorAll('.js_slider_revolution').forEach(function(element) {
        let options = JSON.parse(element.getAttribute('data-options'));
        let sliderWidth = element.offsetWidth;
        let sliderHeight = Math.ceil(sliderWidth * (parseFloat(options.ratioHeight) / parseFloat(options.ratioWidth)));
        let wrapper = element.querySelector('.js_slider_revolution_wrapper');
        if (wrapper) {
            wrapper.style.height = sliderHeight + 'px';
        }
    });

	$(() => {
		$.each($('.js_slider_revolution'), function (index, element) {
			let options = $(this).data('options');
			if(typeof options.ratioHeight == 'undefined') {
				options.ratioHeight = 1;
			}
			if(typeof options.ratioWidth == 'undefined') options.ratioWidth = 3;
			let sliderWidth = $(this).width();
			let sliderHeight = Math.ceil(sliderWidth*(parseFloat(options.ratioHeight)/parseFloat(options.ratioWidth)));
			$(this).css('height', sliderHeight + 'px');
			$(this).find('.js_slider_revolution_box').revolution(options);
		});
	});
</script>