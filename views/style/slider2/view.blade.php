<div id="sliderWidthTitle_{!! $id !!}" class="sliderWidthTitle {!! $sliderOptions['sliderTxtType'] !!} js_slider_title box-content slider_box" style="position: relative" data-id="{!! $id !!}" data-options="{!! htmlentities(json_encode($options)) !!}">
    <div class="arrow_box js_slider_title_arrow">
        <div class="prev arrow"><i class="fal fa-chevron-left"></i></div>
        <div class="next arrow"><i class="fal fa-chevron-right"></i></div>
    </div>
    <div id="js_slider_title_list_{!! $id !!}" class="js_slider_title_list slider_list_item owl-carousel">
       @foreach ($items as $item)
            <div class="item">
                <a aria-label='slide' href="{!! $item->url !!}">
                    {!! Template::img($item->value, $item->name, array('style' => 'cursor:pointer')) !!}
                </a>
            </div>
        @endforeach
    </div>
    <div id="js_slider_title_thumb_{!! $id !!}" class="js_slider_title_thumb slider_list_thumb owl-carousel">
        @foreach ($items as $item)
            <div class="item"><p class="heading">{!! $item->name !!}</p></div>
        @endforeach
    </div>
</div>
<style>
    #sliderWidthTitle_{!! $id !!} {
        --slider-thumb-color:{!! $sliderOptions['sliderTxtColor'] !!};
        --slider-thumb-color-active:{!! $sliderOptions['sliderTxtActive'] !!};
        --slider-thumb-bg:{!! $sliderOptions['sliderTxtBg'] !!};
        --slider-thumb-bg-active:{!! $sliderOptions['sliderTxtBgActive'] !!};
        --slider-thumb-font-size:{!! $sliderOptions['sliderTxtFontSize'] !!};
    }
</style>