<div class="{!! $captionClassId !!} sliderItemCaption positionX--{!! $position['x'] !!} positionY--{!! $position['y'] !!}">
    <div class="sliderItemCaption-wrapper">
        @if(!empty($heading['txt']))
            <div class="sliderItemCaption-title">{!! $heading['txt'] !!}</div>
        @endif
        @if(!empty($description['txt']))
            <div class="sliderItemCaption-detail">{!! $description['txt'] !!}</div>
        @endif
    </div>
</div>

<style>{!! $css !!}</style>