<li class="js_slider_item" style="position: relative" data-id="{{ $item->id }}">
    <div class="js_slider_item_inner item tls-add-news-slider {{($id == $item->id) ? 'active' : '' }}" data-id="{{ $item->id }}" data-group="{{ $item->group_id }}" data-type="{{ $type }}">
        <span class="tls-image mini-transparent" style="background-size: cover; background-repeat: no-repeat;background-position: center;background-image:url('{!! $item->thumb !!}') "></span>
        <span class="tls-title"><span class="tls-title">#slider</span></span>
    </div>
    {!! Admin::btnConfirm('red', [
        'icon'      => Admin::icon('delete'),
        'tooltip'   => 'Xóa slider item',
        'id'        => $item->id,
        'ajax'      => 'SliderItemAdminAjax::delete',
        'model'     => 'Slider',
        'heading'   => 'Xóa Slider item',
        'description' => 'Bạn có chắc chắn muốn xóa slider item ?',
        'style' => 'position: absolute;top:5px;left:5px;',
        'attr' => [
            'callback-success' => 'sliderDetail.deleteSuccess',
        ]
    ]) !!}
    <input id="js_slider_item_sort_{!! $item->id !!}" name="slider_item_order[{!! $item->id !!}]" type="hidden" value="{!! $item->order !!}">
</li>