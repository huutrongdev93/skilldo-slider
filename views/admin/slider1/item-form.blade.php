<div role="tabpanel">
    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
        <li class=""><a href="#bg" class="active" role="tab" data-bs-toggle="tab">Background</a> </li>
        <li class=""><a href="#anima" role="anima" data-bs-toggle="tab">Hiệu ứng</a> </li>
        <li class=""><a href="#caption" role="caption" data-bs-toggle="tab">Captions</a> </li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <!-- Images -->
        <div role="tabpanel" class="tab-pane active m-2" id="bg">
            <div id="bg_type_image">
                {!! $form->html() !!}
            </div>
        </div>

        <!-- Animation -->
        <div role="tabpanel" class="tab-pane m-2" id="anima">
            <div class="system">
                <div class="system-tab" style="padding:0;">
                    <ul class="nav nav-tabs mb-3" role="tablist" style="background-color: #f3f3f3;">
                        <li class="nav-item"><a href="#Fade" data-bs-toggle="tab" class="active show">Flat Fade Transitions</a></li>
                        <li class="nav-item"><a href="#Zoom" data-bs-toggle="tab">Flat Zoom Transitions</a></li>
                        <li class="nav-item"><a href="#Parallax" data-bs-toggle="tab">Flat Parallax Transitions</a></li>
                        <li class="nav-item"><a href="#Slide" data-bs-toggle="tab">Flat Slide Transitions</a></li>
                        <li class="nav-item"><a href="#Premium" data-bs-toggle="tab">Premium Transitions</a></li>
                    </ul>
                </div>
            </div>

            <section class="tool first" id="transitselector" style="float:left; width:25%;padding:0; min-height: 416px; position: relative; top:0;position: initial">
                <div class="tooltext norightcorner long" id="mranim" style="cursor:pointer;display: none;">Fade</div>
                <div class="transition-selectbox-holder">
                    <div class="transition-selectbox">
                        <div class="system-tab-content tab-content" style="float:none;">
                            @foreach ($animations as $key => $data)
                                <div role="tabpanel" class="tab-pane fade {{ ($key == 'Fade')? 'active show':'' }}" id="{{ $key }}">
                                    <ul>
                                        <li class="animchanger" data-anim="">Flat {{ $key }} Transitions</li>
                                        @foreach ($data as $name => $value)
                                            <li class="animchanger" data-anim="{{ $name }}">{{ $value }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="clear"></div>
            </section>

            <div style="float:left; width:50%;">
                @php SliderRevolution::demo($item->data_slotamount, $item->data_masterspeed); @endphp
                <div class="toolpad" style="padding-left: 20px;">
                    <p>
                        <strong>Hiệu ứng:</strong>
                        <input type="text" name="data_transition" id="resultanim" class="form-control" value="{!! $item->data_transition !!}" readonly>
                    </p>
                    <p>
                        <strong>Số khe:</strong>
                        <input type="text" name="data_slotamount" id="resultslot" class="form-control" value="{!! $item->data_slotamount !!}" readonly>
                    </p>
                    <p>
                        <strong>Thời gian hiệu ứng:</strong>
                        <input type="text" name="data_masterspeed" id="resultspeed" class="form-control" value="{!! $item->data_masterspeed !!}" readonly>
                    </p>
                </div>
            </div>
        </div>

        <!-- Caption -->
        <div role="tabpanel" class="tab-pane system m-2" id="caption">
            <div class="d-flex">
                <div class="system-tab" style="padding:0;width: 15%;">
                    <ul class="nav nav-tabs js_slider_item_caption__list" role="tablist" style="min-height: 420px;background-color: var(--content-bg); border-radius: 0;padding:10px;">
                        <li class="">
                            <div class="col-md-12 form-group">
                                <div class="group form-input">
                                    <div class="form-check radio">
                                        <label>
                                            <input type="radio" name="caption_key" value="none" class="form-check-input" {{ ($item->caption_key == 'none') ? 'checked' : '' }}>
                                            &nbsp;&nbsp;Không sử dụng
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </li>
                        @foreach (SliderRevolutionHtml::getCaptions() as $cap_key => $caption_value)
                            <li class="">
                                <div class="col-md-12 form-group">
                                    <div class="group form-input">
                                        <div class="form-check radio">
                                            <label>
                                                <input type="radio" name="caption_key" value="{{ $cap_key }}" data-id="{{ $item->id }}" data-key="{{ $cap_key }}" class="form-check-input" {{ ($item->caption_key == $cap_key) ? 'checked' : '' }}>
                                                &nbsp;&nbsp;{{ $caption_value['label'] }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="slider-layer-list scrollbar" id="js_slider_item_caption__layer">
                    @if($item->caption_key != 'none')
                        @if(file_exists(SLIDER_PATH.'views/admin/slider1/captions/'.$item->caption_key.'/layer_form.blade.php'))
                            {!! Plugin::partial('slider', 'admin/slider1/captions/'.$item->caption_key.'/layer_form', ['caption' => $caption]) !!}
                        @endif
                    @endif
                </div>
                <div class="slider-layer-demo" id="js_slider_item_caption__demo">
                @if($item->caption_key != 'none')
                    {!! Plugin::partial('slider', 'admin/slider1/form-caption', [
                        'caption_key' => $caption_key,
                        'caption' => $caption,
                    ]) !!}
                @endif
            </div>
            </div>
        </div>

        <div class="button text-right">
            <button class="btn btn-green">{!! Admin::icon('save') !!} Lưu</button>
        </div>
    </div>
</div>
<style>
    .slider-layer-demo {
        float: left;
        width: 50%;
        position: relative;
    }
    .slider-layer-list {
        float: left;
        width: 35%;
        background: #fff;
        border: 5px solid #ccc;
        padding:5px;
        height: 420px;
        overflow-y: auto;
    }
    .slider-layer-list h4 {
        cursor: default;
        font-size: 14px;
        color: #888;
        font-weight: 800;
        text-transform: uppercase;
        margin-bottom: 14px;
        padding: 0;
        background: transparent;
    }
    .slider-layer-item h5 {
        padding: 10px 10px; color:#000; font-weight: bold;
        border-bottom: 1px dashed #888;
    }
    .slider-layer-item {
        overflow: hidden;
        background-color: var(--content-bg);
        margin-bottom: 10px;
    }
    .transition-selectbox, .jspContainer, .jspPane {
        min-height:390px;
    }
</style>
<script>
    $(function (){
        $(document).on('change','.js_slider_item_caption__list li input', function(e) {

            let id = $(this).attr('data-key');

            let data = {
                'action'        : 'SliderRevolutionAjax::itemCaptionLoad',
                'caption_key'	: id,
                'id'	        : $(this).attr('data-id'),
            };

            request.post(ajax, data).then(function( response ) {
                if( response.status === 'success') {
                    $('#js_slider_item_caption__layer').html(response.data);
                    $('#js_slider_item_caption__demo').html(response.slider);
                    $('.item-color input').spectrum({
                        type: "color",
                        showInput: true,
                        showInitial: true,
                        chooseText: "Chọn", cancelText: "Hủy"
                    });
                    $('.item-color-hexa input').spectrum({
                        type: "component",
                        showInput: true,
                        showInitial: true,
                        chooseText: "Chọn"
                    });
                }
            });
        });
    });
</script>

