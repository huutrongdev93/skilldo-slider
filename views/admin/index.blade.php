<div class="ui-title-bar__group">
	<h1 class="ui-title-bar__title">Slider</h1>
	<div class="ui-title-bar__action">
        {!! Admin::button('blue', [
            'icon' => Admin::icon('add'),
            'text' => trans('slider.button.add'),
            'modal' => 'modelAddSlider'
        ]) !!}
    </div>
</div>
<div class="box mb-2 list-sliders">
    <div class="box-content p-2">
        <div class="sliders-list">
            @foreach ($sliders as $key => $slider)
                @php $sliderType = Slider::list($slider->options) @endphp
                <a href="{!! Url::admin('plugins?page=slider&view=detail&id='.$slider->id) !!}">
                    <div class="item">
                        <span class="slider-first-image" style="background-size: inherit; background-repeat: repeat;;background-image:url({!! Path::plugin('slider').'/assets/images/Transparent_Background.webp' !!}) "></span>
                        <span class="slider-title-wrapper"><span class="slider-title">{!! $slider->name !!}</span></span>
                        <div class="slider-button">
                            <button class="btn btn-red js_slider__delete" data-id="{{$slider->id}}" style="position: relative;top:5px;">{!! Admin::icon('delete') !!}</button>
                            @if($sliderType['options'] == 'true')
                            <button class="btn btn-green js_slider__options" data-id="{{$slider->id}}" style="position: relative;top:5px;"><i class="fa-thin fa-gear"></i></button>
                            @endif
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</div>

<div class="box mb-2 js_slider_options_box" style="display: none">
	<div class="box-content p-2">
		<div id="sliderOptionsModal">
			<form action="" id="js_slider_form__options" autocomplete="off">
				<div class="row" id="sliderOptionsModal_content"></div>
				<div class="text-right">
					<button class="btn btn-blue">{!! Admin::icon('save') !!} Lưu</button>
				</div>
			</form>
		</div>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="modelAddSlider" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ trans('slider.modal.add.title') }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            {!! $form->open(); !!}
            <div class="modal-body">
                {!! Admin::loading() !!}
                {!! $form->html(); !!}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                {!! Admin::button('blue', [
                    'icon' => Admin::icon('save'),
                    'text' => 'Thêm',
                    'type' => 'submit'
                ]) !!}
            </div>
            {!! $form->close(); !!}
        </div>
    </div>
</div>

<style>
	.sliders-list {
		display: flex; gap:10px;
	}
    .sliders-list .item {
        position: relative;
        width: 220px;
        height: 160px;
        border: 1px dashed #ddd;
        background: transparent;
        box-sizing: border-box;
        overflow: hidden;
	    border-radius: 5px;
    }
    .sliders-list .item:hover, .sliders-list .item.active {
        border: 1px solid #242424;
    }
    .sliders-list .item:hover .slider-title, .sliders-list .item.active .slider-title {
        color:#fff;
    }
    .slider-title-wrapper {
        vertical-align: middle;
        position: absolute;
        bottom: 0;
        color: #fff;
        padding: 5px 10px;
        width: 100%;
        line-height: 20px;
        background: #eee;
        box-sizing: border-box;
    }
    .slider-title, .slider-title a {
        color: #555;
        text-decoration: none;
        font-size: 11px;
        line-height: 20px;
        font-weight: 600;
    }
    .slider-first-image {
        position: absolute;
        top: 0;
        left:0;
        width: 100%;
        height: 100%;
    }
    .select-img .checkbox {
        width: 32%; cursor: pointer;
    }
    .select-img .checkbox img {
        max-width: 100%!important; width: 400px;
    }
</style>