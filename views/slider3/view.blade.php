<div id="sliderNoTitle_{!! $id !!}" class="sliderNoTitle stick-dots js_slider_title box-content slider_box" style="position: relative" data-id="{!! $id !!}" data-options="{!! htmlentities(json_encode($options)) !!}">
    <div class="sliderNoTitleWrapper">
        <div class="arrow_box js_slider_title_arrow">
            <div class="prev arrow"><i class="fal fa-chevron-left"></i></div>
            <div class="next arrow"><i class="fal fa-chevron-right"></i></div>
        </div>
        <div id="js_slider_title_list_{{ $id }}" class="js_slider_title_list slider_list_item owl-carousel">
            @foreach ($items as $item)
                {!! $item->render() !!}
            @endforeach
        </div>
    </div>
</div>

