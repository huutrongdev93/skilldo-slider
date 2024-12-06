<div class="box-header">
    {!! Admin::tabs([
        'background'    => ['label' => 'Background'],
        'transition'    => ['label' => 'Hiệu ứng chuyển cảnh'],
        'captions'      => ['label' => 'Captions'],
    ], 'background') !!}
</div>
<div class="box-content">
    <div class="tab-content">
        <!-- Images -->
        <div role="tabpanel" class="tab-pane m-2 active" id="background">
            {!! $form->html() !!}
        </div>

        <!-- Animation -->
        <div role="tabpanel" class="tab-pane m-2" id="transition">
            <div class="slider-transition-list">
                <ul class="nav nav-tabs nav-tabs-horizontal mb-2" role="tablist">
                    @foreach ($transitions as $transitionObj)
                        <li class="nav-item" role="presentation">
                            <a class="nav-link pt-3 pb-3 ps-1 {{ ($item->transtion_key == $transitionObj->key) ? 'active' : '' }}" href="#">
                                <input type="radio" name="transition_key" value="{{ $transitionObj->key }}" data-id="{{ $item->id }}" data-key="{{ $transitionObj->key }}"  {{ ($item->caption_key == $transitionObj->key) ? 'checked' : '' }} style="display: none">
                                &nbsp;&nbsp;{{ $transitionObj->label }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="d-flex gap-2">
                <div class="slider-form scrollbar p-3" style="min-height: 300px; min-width:200px; width: 30%;">
                    <div class="row" id="js_slider_item_transition__form">
                    @if($item->transtion_key != 'none')
                        {!! $transition->form() !!}
                    @endif
                    </div>
                </div>

                <div class="slider-transition-demo" id="js_slider_item_transition__demo" style="min-height: 300px; width: 70%;">
                    @if($item->transtion_key != 'none')
                        {!! $transition->demo() !!}
                    @endif
                </div>
            </div>
        </div>

        <!-- Caption -->
        <div role="tabpanel" class="tab-pane" id="captions">
            <div class="slider-caption-list">
                <ul class="nav nav-tabs nav-tabs-horizontal mb-2" id="js_slider_item_caption__list">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link pt-3 pb-3 ps-1 {{ ($item->caption_key == 'none') ? 'active' : '' }}" href="#">
                            <input type="radio" name="caption_key" value="none" data-id="{{ $item->id }}" data-key="none"  {{ ($item->caption_key == 'none') ? 'checked' : '' }} style="display: none">
                            &nbsp;&nbsp;Không có caption
                        </a>
                    </li>
                    @foreach ($captions as $captionObject)
                        <li class="nav-item" role="presentation">
                            <a class="nav-link pt-3 pb-3 ps-1 {{ ($item->caption_key == $captionObject->key) ? 'active' : '' }}" href="#">
                                <input type="radio" name="caption_key" value="{{ $captionObject->key }}" data-id="{{ $item->id }}" data-key="{{ $captionObject->key }}"  {{ ($item->caption_key == $captionObject->key) ? 'checked' : '' }} style="display: none">
                                &nbsp;&nbsp;{{ $captionObject->label }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="d-flex gap-2">
                <div class="slider-form scrollbar p-3" style="min-height: 400px; min-width:200px; width: 30%;">
                    <div class="row" id="js_slider_item_caption__form">
                        @if($item->caption_key != 'none')
                            {!! $caption->form() !!}
                        @endif
                    </div>
                </div>
                <div class="slider-caption-demo mt-3" id="js_slider_item_caption__demo" style="min-height: 400px; width: 70%;">
                    @if($item->caption_key != 'none')
                        {!! $caption->demo() !!}
                    @endif
                </div>

            </div>

        </div>
    </div>
</div>

<div class="box-footer">
    <button class="btn btn-green" type="submit">{!! Admin::icon('save') !!} Lưu</button>
</div>

<style>
    .slider-caption-demo {
        position: relative;
    }
    .slider-form {
        overflow-y: auto;
        box-shadow: 0 0 0 1px rgba(63, 63, 68, 0.05), 0 1px 3px 0 rgba(63, 63, 68, 0.15);
        border-radius: 3px;
        max-height: 400px;
    }
    .slider-form h4 {
        cursor: default;
        font-size: 14px;
        color: #888;
        font-weight: 800;
        text-transform: uppercase;
        margin: 14px 0;
    }
</style>
