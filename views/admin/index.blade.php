<nav aria-label="breadcrumb" style="margin-top: 20px;">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{!! Url::admin() !!}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{!! Url::admin('theme/option') !!}">Giao diện</a></li>
        <li class="breadcrumb-item active" aria-current="slider">Slider</li>
    </ol>
</nav>
<div class="ui-title-bar__group">
    <h1 class="ui-title-bar__title text-3xl">Slider</h1>
</div>

<div class="box">
    <div class="box-header text-right">
        {!! Admin::button('blue', [
            'icon' => Admin::icon('add'),
            'text' => trans('slider.button.add'),
            'modal' => 'modelAddSlider'
        ]) !!}
    </div>
    <div class="box-content">
        {!! Admin::loading('js_slider_loading') !!}
        <div class="slider-list" id="js_slider_list_wrapper"></div>
    </div>
</div>

<div class="box mt-2 js_slider_options_box" style="display: none">
    <div class="box-content p-3">
        <div id="sliderOptionsModal">
            {!! Admin::loading() !!}
            <form action="" id="js_slider_options_form" autocomplete="off">
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
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            {!! $form->open(); !!}
            <div class="modal-body">
                {!! Admin::loading() !!}
                {!! $form->html(); !!}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-bs-dismiss="modal">{!! trans('button.close') !!}</button>
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
    .slider-list {
        display: flex; gap:10px;
    }
    .slider-list .item {
        display: block;
        position: relative;
        width: 220px;
        height: 160px;
        border: 1px dashed #ddd;
        background: transparent;
        box-sizing: border-box;
        overflow: hidden;
        border-radius: 5px;
    }
    .slider-list .item:hover,
    .slider-list .item.active {
        border: 1px solid #242424;
    }
    .slider-list .item:hover .slider-title,
    .slider-list .item.active .slider-title {
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