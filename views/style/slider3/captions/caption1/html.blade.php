@php
$caption['heading'] = array_merge([
    'txt'           => 'Jungle Safari Resort',
    'color'         => '#fff',
    'fontWeight'    => 'bold',
    'fontSize'      => 30,
    'fontFamily'    => 0,
    'lineHeight'    => 40,
], $caption['heading']);
$caption['description'] = array_merge([
    'txt'           => 'Food indulgence in mind, come next door and sate your desires with our ever changing internationally and seasonally.',
    'color'         => '#fff',
    'fontWeight'    => '400',
    'fontSize'      => 20,
    'fontFamily'    => 0,
    'lineHeight'    => 30,
], $caption['description']);
$caption['headingMobile'] = array_merge([
    'color'         => '#fff',
    'fontWeight'    => 'bold',
    'fontSize'      => 20,
    'fontFamily'    => 0,
    'lineHeight'    => 20,
], $caption['headingMobile']);
$caption['descriptionMobile'] = array_merge([
    'color'         => '#fff',
    'fontWeight'    => '400',
    'fontSize'      => 14,
    'fontFamily'    => 0,
    'lineHeight'    => 20,
], $caption['descriptionMobile']);
@endphp
<div class="sliderItemCaption positionX--{!! $caption['position']['x'] !!} positionY--{!! $caption['position']['y'] !!}" style="
        --slider-caption1-heading-color: {!! $caption['heading']['color'] !!};
        --slider-caption1-heading-font: {!! $caption['heading']['fontFamily'] !!};
        --slider-caption1-heading-size: {!! $caption['heading']['fontSize'] !!}px;
        --slider-caption1-heading-weight: {!! $caption['heading']['fontWeight'] !!};
        --slider-caption1-heading-height: {!! $caption['heading']['lineHeight'] !!}px;
        --slider-caption1-headingM-color: {!! $caption['headingMobile']['color'] !!};
        --slider-caption1-headingM-font: {!! $caption['headingMobile']['fontFamily'] !!};
        --slider-caption1-headingM-size: {!! $caption['headingMobile']['fontSize'] !!}px;
        --slider-caption1-headingM-weight: {!! $caption['headingMobile']['fontWeight'] !!};
        --slider-caption1-headingM-height: {!! $caption['headingMobile']['lineHeight']  !!}px;
        --slider-caption1-des-color: {!! $caption['description']['color'] !!};
        --slider-caption1-des-font: {!! $caption['description']['fontFamily'] !!};
        --slider-caption1-des-size: {!! $caption['description']['fontSize']  !!}px;
        --slider-caption1-des-weight: {!! $caption['description']['fontWeight'] !!};
        --slider-caption1-des-height: {!! $caption['description']['lineHeight']  !!}px;
        --slider-caption1-desM-color: {!! $caption['descriptionMobile']['color'] !!};
        --slider-caption1-desM-font: {!! $caption['descriptionMobile']['fontFamily'] !!};
        --slider-caption1-desM-size: {!! $caption['descriptionMobile']['fontSize']  !!}px;
        --slider-caption1-desM-weight: {!! $caption['descriptionMobile']['fontWeight'] !!};
        --slider-caption1-desM-height: {!! $caption['descriptionMobile']['lineHeight']  !!}px;">
    <div class="sliderItemCaption-wrapper">
        @if(!empty($caption['heading']['txt']))
            <div class="sliderItemCaption-title">{!! $caption['heading']['txt'] !!}</div>
        @endif
        @if(!empty($caption['description']['txt']))
            <div class="sliderItemCaption-detail">{!! $caption['description']['txt'] !!}</div>
        @endif
    </div>
</div>