<div class="sliderItem">
    <a aria-label='slide' href="{!! $item->url !!}">
        {!! Image::source($item->value, $item->name)->attributes(['style' => 'cursor:pointer'])->html() !!}
        @if(!empty($caption))
            {!! $caption->layers() !!}
        @endif
    </a>
</div>