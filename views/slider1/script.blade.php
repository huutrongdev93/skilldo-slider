<script async>
    document.querySelectorAll('.js_slider_revolution_{!! $id !!}').forEach(function(element) {

        let options = JSON.parse(element.getAttribute('data-options') || '{}');

        if (typeof options.ratioHeight === 'undefined') {
            options.ratioHeight = 1;
        }
        if (typeof options.ratioWidth === 'undefined') {
            options.ratioWidth = 3;
        }

        let sliderWidth = element.offsetWidth;

        let sliderHeight = Math.ceil(sliderWidth * (parseFloat(options.ratioHeight) / parseFloat(options.ratioWidth)));

        let wrapper = element.querySelector('.js_slider_revolution_wrapper');

        if (wrapper)
        {
            wrapper.style.height = sliderHeight + 'px';
        }

        element.style.height = sliderHeight + 'px';

        let sliderBox = element.querySelector('.js_slider_revolution_box');

        if (sliderBox && typeof $(sliderBox).revolution === 'function')
        {
            $(sliderBox).revolution(options);
        }
    });
</script>