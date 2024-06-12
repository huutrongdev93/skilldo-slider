<div class="js_slider_revolution js_slider_container" style="position: relative;" data-options="{!! htmlentities(json_encode($options)) !!}">
    <div class="js_slider_revolution_box">
        <ul>
            @foreach ($items as $item)
                {!! SliderRevolutionHtml::item($item) !!}
            @endforeach
        </ul>
    </div>
</div>