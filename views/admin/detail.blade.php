<div class="ui-title-bar__group">
	<h1 class="ui-title-bar__title">Slider {!! $slider->name !!}</h1>
	<a href="{!! Url::admin('plugins?page=slider') !!}">{{trans('slider.detail.back')}}</a>
</div>
<div class="box mb-2 list-sliders">
    <div class="box-content" style="padding: 10px;">
        <ul id="js_slider_item__sort" style="list-style: none;">
            @foreach ($items as $key => $item)
            <li class="js_slider_item" data-id="{{$item->id}}" data-group="{{$item->group_id}}" data-type="{{$slider->options}}">
                <div class="item tls-add-news-slider {{($id == $item->id) ? 'active' : ''}}">
                    <span class="tls-image mini-transparent" style="background-size: cover; background-repeat: no-repeat;background-position: center;background-image:url('{!! $item->thumb !!}') "></span>
                    <span class="tls-title"><span class="tls-title">#{{$key + 1}} slider</span></span>
                    <div class="tls-button">
                        {!! Admin::button('red', [
                            'icon' => Admin::icon('delete'),
                            'class' => 'js_slider_item__delete',
                            'style' => ['position' => 'relative', 'top' => '5px'
                        ]]) !!}
                    </div>
                </div>
                <input id="js_slider_item_sort_{!! $item->id !!}" name="slider_item_order[{!! $item->id !!}]" type="hidden" value="{!! $item->order !!}">
            </li>
            @endforeach
            <a href="#" data-id="{!! $id !!}" id="js_slider_item__add">
                <div class="item tls-tls-add-news-slider">
                    <span class="tls-new-icon"><span class="slider_list_add_buttons add_new_slider_icon"></span></span>
                    <span class="tls-title"><span class="tls-title">Add Item</span></span>
                </div>
            </a>
        </ul>
    </div>
</div>

<div class="box mb-2 list-sliders">
    <div class="box-content" style="padding: 10px;position: relative; min-height: 300px" id="js_slider_item_box__edit">
        {!! Admin::loading() !!}
        @if(!empty($sliderClass) && method_exists($sliderClass, 'assetsAdmin'))
            {!! $sliderClass::assetsAdmin() !!}
        @endif
        <form action="" id="js_slider_item__edit"></form>
    </div>
</div>
<style>
    #js_slider_item__sort {
        display: grid;
        grid-template-columns: repeat(6, 1fr); gap:10px;
    }
    .list-sliders .item {
        position: relative;
        margin-bottom: 10px;
        margin-right: 10px;
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
    .list-sliders .item .tls-title {
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
    .list-sliders .item .tls-new-icon {
        position: absolute;
        top: 0;
        width: 100%;
        height: 100%;
        display: block;
        text-align: center;
        font-size: 35px;
    }
    .list-sliders .item .tls-title, .list-sliders .item.tls-title a {
        color: #555;
        text-decoration: none;
        font-size: 11px;
        line-height: 20px;
        font-weight: 600;
    }
    .list-sliders .item .slider_list_add_buttons {
        display: block;
        position: absolute; left: 0;top:0;
        width: 100%;
        height: 100%;
        background-position: center center;
        background-repeat: no-repeat;
        background-size: 40px 40px;
        margin-top: -10px;
    }
    .list-sliders .item .tls-image {
        position: absolute;
        top: 0; left:0;
        width: 100%;
        height: 100%;
    }
    .list-sliders .item .tls-image {
        position: absolute;
        top: 0; left:0;
        width: 100%;
        height: 100%;
    }
    .list-sliders .item .tls-button {
        position: absolute;
        top: 10px; left: 10px;
    }

    .list-sliders .item:hover, .list-sliders .item.active {
        border: 1px solid #242424;
    }
    .list-sliders .item:hover .tls-title, .list-sliders .item.active .tls-title {
        background: #252525;
    }
    .list-sliders .item:hover .tls-title, .list-sliders .item.active .tls-title {
        color:#fff;
    }

    .add_new_slider_icon {
        background-image: url('<?php echo plugin_dir_path('slider').'assets/images/new_slider.png';?>');
    }

    .bg-settings-block {
        margin-bottom: 10px;
        line-height: 33px;
        color: #777;
        font-weight: 100;
    }
    .bg-settings-block label { font-weight: 100; font-size: 18px; }
    .bg-settings-detail-block { display: none; }
    .bg-settings-detail-block.active { display: block; }
    .transition-selectbox-holder {
        top:0!important;
        opacity: 1!important;
        display: block!important;position: inherit!important;
        transform: none !important;
        padding: 0;
    }
    .transition-selectbox, .jspContainer, .jspPane {
        width: 100%!important;
    }
    .transition-selectbox {position: inherit!important;}
    .transition-selectbox-holder {
        border-radius:0;
        height: 414px;
        padding:10px;
    }
    .icheckbox_square-blue, .iradio_square-blue { background-color: transparent; }
    .toolpad { padding:20px 10px; border:none; overflow: hidden;}
    .toolpad .tool {
        width: 50%!important;
    }
    .toolcontroll { width: 34px; }
</style>
@if(!empty($sliderClass) && method_exists($sliderClass, 'scriptAdmin'))
    {!! $sliderClass::scriptAdmin() !!}
@endif