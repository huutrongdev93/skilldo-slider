
    <div class="slider-item" style="position: relative">
        <a href="{!! Url::admin('plugins/slider?view=detail&id='.$slider->id) !!}" class="item">
            <span class="slider-first-image" style="background-size: inherit; background-repeat: repeat;;background-image:url({!! Image::plugin('slider', 'assets/images/Transparent_Background.webp')->link() !!}) "></span>
            <span class="slider-title-wrapper"><span class="slider-title">{!! $slider->name !!}</span></span>
        </a>
        <div class="slider-button d-fex gap-2 align-items-center" style="position: absolute;top:5px;left:5px;">
            {!! Admin::btnConfirm('red', [
                'icon'      => Admin::icon('delete'),
                'tooltip'   => 'Xóa slider '.$slider->name,
                'id'        => $slider->id,
                'ajax'      => 'SliderAdminAjax::delete',
                'model'     => 'Slider',
                'heading'   => 'Xóa Slider',
                'description' => 'Bạn có chắc chắn muốn xóa slider '.$slider->name.' ?',
                'style' => '',
                'attr' => [
                    'callback-success' => 'sliderIndex.deleteSuccess',
                ]
            ]) !!}
            @if($sliderType['options'] == 'true')
                <button class="btn btn-green js_slider_options_btn" data-id="{{$slider->id}}"><i class="fa-thin fa-gear"></i></button>
            @endif
        </div>
    </div>
