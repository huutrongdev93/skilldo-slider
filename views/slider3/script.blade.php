<script>
    document.querySelectorAll('.js_slider_title').forEach(function(element) {
        let options = JSON.parse(element.getAttribute('data-options'));
        let sliderWidth = element.offsetWidth;
        let sliderHeight = Math.ceil(sliderWidth * (parseFloat(options.ratioHeight) / parseFloat(options.ratioWidth)));
        let wrapper = element.querySelector('.sliderNoTitleWrapper');
        if (wrapper) {
            wrapper.style.height = sliderHeight + 'px';
        }
    });


	$(() => {
		$.each($('.js_slider_title'), function (index, element) {
			let options = $(this).data('options');
			let sliderWidth = $(this).width();
			let sliderHeight = Math.ceil(sliderWidth*(parseFloat(options.ratioHeight)/parseFloat(options.ratioWidth)));

			$(this).find('.js_slider_title_list .sliderItem').css('height', sliderHeight+'px');

			$(window).resize(function () {
				sliderWidth = $(this).width();
				sliderHeight = Math.ceil(sliderWidth*(parseFloat(options.ratioHeight)/parseFloat(options.ratioWidth)));
				$(this).find('.js_slider_title_list .sliderItem').css('height', sliderHeight + 'px');
			});

			let sliderMain = $(this).find('.js_slider_title_list');
			let arrowNext = $(this).find('.js_slider_title_arrow .next');
			let arrowPrev = $(this).find('.js_slider_title_arrow .prev');

			sliderMain.slick({
				slidesToShow: 1,
				slidesToScroll: 1,
				arrows: false,
				fade: true,
				autoplay: false,
				loop:true,
				lazyLoad: 'progressive',
				dots: true,
			});
			arrowNext.click(function() {
				sliderMain.slick('slickNext'); return false;
			});
			arrowPrev.click(function() {
				sliderMain.slick('slickPrev'); return false;
			});
		});
	});
</script>