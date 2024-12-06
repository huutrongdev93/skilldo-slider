<div id="sliderWidthTitle_{!! $id !!}" class="sliderWidthTitle {!! $options['sliderTxtType'] !!} js_slider_title box-content slider_box" style="position: relative" data-id="{!! $id !!}" data-options="{!! htmlentities(json_encode($options)) !!}">
    <div class="arrow_box js_slider_title_arrow">
        <div class="prev arrow"><i class="fal fa-chevron-left"></i></div>
        <div class="next arrow"><i class="fal fa-chevron-right"></i></div>
    </div>
    <div id="js_slider_title_list_{!! $id !!}" class="js_slider_title_list slider_list_item owl-carousel">
       @foreach ($items as $item)
            <div class="item">
                <a aria-label='slide' href="{!! $item->url !!}">
                    {!! Image::source($item->value, $item->name)->attributes(['style' => 'cursor:pointer'])->html() !!}
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
        --slider-thumb-color:{!! $options['sliderTxtColor'] !!};
        --slider-thumb-color-active:{!! $options['sliderTxtActive'] !!};
        --slider-thumb-bg:{!! $options['sliderTxtBg'] !!};
        --slider-thumb-bg-active:{!! $options['sliderTxtBgActive'] !!};
        --slider-thumb-font-size:{!! $options['sliderTxtFontSize'] !!}px;
    }
</style>