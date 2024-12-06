<link rel="stylesheet" type="text/css" href="views/plugins/slider/assets/slider1/src/css/settings.css" media="screen" />
<script type="text/javascript" src="views/plugins/slider/assets/slider1/src/js/jquery.themepunch.plugins.min.js"></script>
<script type="text/javascript" src="views/plugins/slider/assets/slider1/src/js/jquery.themepunch.revolution.min.js"></script>
<script>
    $(document).ready(function() {

        $(document).on('change', '#js_slider_item_transition__form #transition_effect', function() {
            SliderReview.callChanger1()
        })

        $(document).on('click', '#js_slider_item_transition__form #decTime', function() {
            let box = $(this).closest('.tool');
            let input = box.find('input[name="transition[speed]"]');
            let value = parseInt(input.val());
            if (value > 100)
            {
                value -= 100;
            }
            input.val(value);
            box.find('#mrTime').text('Time: ' + (value/1000).toFixed(1) + 's');
            SliderReview.callChanger1()
        })

        $(document).on('click', '#js_slider_item_transition__form #incTime', function() {
            let box = $(this).closest('.tool');
            let input = box.find('input[name="transition[speed]"]');
            let value = parseInt(input.val());
            value += 100;
            input.val(value);
            box.find('#mrTime').text('Time: ' + (value/1000).toFixed(1) + 's');
            SliderReview.callChanger1()
        })

        $(document).on('click', '#js_slider_item_transition__form #decSlot', function() {
            let box = $(this).closest('.tool');
            let input = box.find('input[name="transition[slot]"]');
            let value = parseInt(input.val());
            if (value > 1)
            {
                value -= 1;
            }
            input.val(value);
            box.find('#mrSlot').text('Slots:' + value);
            SliderReview.callChanger1()
        })

        $(document).on('click', '#js_slider_item_transition__form #incSlot', function() {
            let box = $(this).closest('.tool');
            let input = box.find('input[name="transition[slot]"]');
            let value = parseInt(input.val());
            value += 1;
            input.val(value);
            box.find('#mrSlot').text('Slots:' + value);
            SliderReview.callChanger1()
        })
    })
</script>