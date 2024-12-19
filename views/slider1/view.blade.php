<div class="js_slider_revolution js_slider_container js_slider_revolution_{!! $id !!}" style="position: relative;" data-options="{!! htmlentities(json_encode($options)) !!}">
    <div class="js_slider_revolution_wrapper" style="overflow: hidden">
        <div class="js_slider_revolution_box">
            <ul>
                @foreach ($items as $item)
                    {!! $item->render() !!}
                @endforeach
            </ul>
        </div>
    </div>
</div>