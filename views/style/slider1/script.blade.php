<script>
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