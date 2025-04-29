<nav aria-label="breadcrumb" style="margin-top: 20px;">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{!! Url::admin() !!}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{!! Url::admin('theme/option') !!}">Giao diện</a></li>
        <li class="breadcrumb-item active" aria-current="slider">Slider</li>
    </ol>
</nav>
<div class="ui-title-bar__group">
    <h1 class="ui-title-bar__title text-3xl mb-3">Slider {!! $slider->name !!}</h1>
    <a href="{!! Url::admin('plugins/slider') !!}">{{ trans('slider.detail.back') }}</a>
</div>
<div class="box mb-2 slider-detail" data-slider-id="{!! $slider->id !!}" data-slider-type="{!! $slider->options !!}">
    <div class="box-content">
        <ul id="js_slider_items_list" class="slider-items-list mb-0" style="list-style: none;">
            @foreach ($items as $key => $item)
                {!! Plugin::partial('slider', 'admin/detail/item', ['item' => $item, 'id' => $id]) !!}
            @endforeach
            <div id="js_slider_item__add">
                <div class="item tls-tls-add-news-slider">
                    <span class="tls-new-icon"><span class="slider_list_add_buttons add_new_slider_icon"></span></span>
                    <span class="tls-title"><span class="tls-title">Thêm item</span></span>
                </div>
            </div>
        </ul>
    </div>
</div>

<div class="box mb-2 slider-detail" style="position: relative;" id="js_slider_item_edit">
    {!! Admin::loading() !!}
    <form action="" id="js_slider_item_edit_form"></form>
</div>
<style>
    .slider-items-list {
        display: grid;
        grid-template-columns: repeat(6, 1fr); gap:10px;
    }
    .slider-items-list .item {
        position: relative;
        border: 1px dashed #ddd;
        background: transparent;
        box-sizing: border-box;
        overflow: hidden;
        cursor: pointer;
        border-radius: 5px;
        width: 100%;
        padding-top:100%;
        height: auto;
    }
    .slider-items-list .item .tls-title {
        vertical-align: middle;
        position: absolute;
        bottom: 0; left: 0;
        color: #fff;
        padding: 5px 10px;
        width: 100%;
        line-height: 20px;
        background: #eee;
        box-sizing: border-box;
    }
    .slider-items-list .item .tls-new-icon {
        position: absolute;
        top: 0;
        width: 100%;
        height: 100%;
        display: block;
        text-align: center;
        font-size: 35px;
    }
    .slider-items-list .item .tls-title, .slider-detail .item.tls-title a {
        color: #555;
        text-decoration: none;
        font-size: 11px;
        line-height: 20px;
        font-weight: 600;
    }
    .slider-items-list .item .slider_list_add_buttons {
        display: block;
        position: absolute; left: 0;top:0;
        width: 100%;
        height: 100%;
        background-position: center center;
        background-repeat: no-repeat;
        background-size: 40px 40px;
        margin-top: -10px;
    }
    .slider-items-list .item .tls-image {
        position: absolute;
        top: 0; left:0;
        width: 100%;
        height: 100%;
    }
    .slider-items-list .item .tls-image {
        position: absolute;
        top: 0; left:0;
        width: 100%;
        height: 100%;
    }
    .slider-items-list .item .tls-button {
        position: absolute;
        top: 10px; left: 10px;
    }
    .slider-items-list .item:hover,
    .slider-items-list .item.active {
        border: 1px solid #242424;
    }
    .slider-items-list .item:hover .tls-title,
    .slider-items-list .item.active .tls-title {
        background: #252525;
    }
    .slider-items-list .item:hover .tls-title,
    .slider-items-list .item.active .tls-title {
        color:#fff;
    }
    .add_new_slider_icon {
        background-image: url('{!! SLIDER_PATH.'/assets/images/new_slider.png' !!}');
    }
</style>
@if(!empty($sliderClass) && method_exists($sliderClass, 'adminScript'))
    {!! $sliderClass->adminScript() !!}
@endif