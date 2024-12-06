<li
    data-transition="{{ $item->transition['effect'] }}"
    data-slotamount="{{ $item->transition['slot'] }}"
    data-masterspeed="{{ $item->transition['speed'] }}"
    data-link="{!! $item->url !!}">
    @if($item->type == 'youtube')
        <div class="tp-caption tp-fade fadeout fullscreenvideo"
             data-x="0" data-y="0" data-speed="1000" data-start="1100"
             data-easing="Power4.easeOut"
             data-endspeed="1500"
             data-endeasing="Power4.easeIn"
             data-autoplay="true"
             data-autoplayonlyfirsttime="false"
             data-nextslideatend="true"
             data-forceCover="1"
             data-aspectratio="16:9"
             data-forcerewind="on"
             style="z-index: 2">
            <iframe src="https://www.youtube.com/embed/{!! Url::getYoutubeID($item->value) !!}?controls=0&autoplay=1" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        </div>
    @endif
    @if($item->type == 'video')
        <div class="tp-caption tp-fade fadeout fullscreenvideo"
             data-x="0" data-y="0" data-speed="1000" data-start="1100"
             data-easing="Power4.easeOut"
             data-endspeed="1500"
             data-endeasing="Power4.easeIn"
             data-autoplay="true"
             data-autoplayonlyfirsttime="false"
             data-nextslideatend="true"
             data-forceCover="1"
             data-aspectratio="16:9"
             data-forcerewind="on"
             style="z-index: 2">
            <video muted
                   class="video-js vjs-default-skin"
                   preload="none"
                   width="100%"
                   height="100%"
                   poster="uploads/banne-slider-1.jpg"
                   data-setup="{}"><source src="{!! Template::imgLink($item->value) !!}" type="video/mp4"/></video>';
        </div>
    @endif
    @if($item->type == 'image')
        {!! Image::source($item->value, $item->name)->attributes([
            'data-bgfit' => "cover",
            'data-bgposition' => "left top",
            'data-bgrepeat' => "no-repeat"
        ])->html() !!}
    @endif
    @if(!empty($caption))
        {!! $caption->layers() !!}
    @endif

</li>