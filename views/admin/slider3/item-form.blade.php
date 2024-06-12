{!!
    Admin::tabs([
        'bg' => ['label'   => 'Background',],
        'caption' => ['label'   => 'Captions',],
    ], 'bg')
!!}

<div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="bg">
        <div id="bg_type_image">
            {!! $form->html() !!}
        </div>
    </div>
    <!-- Caption -->
    <div role="tabpanel" class="tab-pane" id="caption">
        <div class="d-flex">
            <div class="captionList" style="width: 20%;">
                <div class="box">
                    <div class="box-content p-0">
                        <ul class="mb-0 jsCaptionList" role="tablist" style="background-color: var(--content-bg);">
                            <li class="captionListItem">
                                <input class="captionListInput" type="radio" name="captionKey" value="none" id="layer_none" <?php echo (empty($item->captionKey)) ? 'checked' : '';?>>
                                <label class="captionListLabel" for="layer_none">Không sử dụng</label>
                            </li>
                            @foreach (SliderNoTitleHtml::getCaptions() as $capKey => $captionValue)
                                <li class="captionListItem">
                                    <input class="captionListInput" type="radio" name="captionKey" value="{!! $capKey !!}" id="layer_{!! $capKey !!}" {!! ($item->captionKey == $capKey) ? 'checked' : '' !!}>
                                    <label class="captionListLabel" for="layer_{!! $capKey !!}" data-key="{!! $capKey !!}" data-id="{{ $item->id }}">{!! $captionValue['label'] !!}</label>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="captionConfig scrollbar" id="jsCaptionConfigContent">
                @if($item->captionKey != 'none')
                    @if(file_exists(SLIDER_PATH.'views/admin/slider3/captions/'.$item->captionKey.'/layer_form.blade.php'))
                        {!! Plugin::partial('slider', 'admin/slider3/captions/'.$item->captionKey.'/layer_form', ['caption' => $caption]) !!}
                    @endif
                @endif
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="button text-right">
        <button class="btn btn-green">{!! Admin::icon('save') !!} Lưu</button>
    </div>
</div>
<style>
    .captionList ul {
        height:400px;
    }
    .captionList ul li {
        display:block; width:100%;
    }
    .captionList ul li .captionListLabel {
        padding:10px; display:block; width:100%; cursor: pointer;
    }
    .captionList ul li .captionListInput {
        display: none;
    }
    .captionList ul li .captionListInput:checked + .captionListLabel {
        background-color: var(--menu-bg); color:#416dea;
    }
    .captionConfig {
        width:calc(100% - 20%);
        height: 400px;
        overflow-y: auto;
        border:2px solid var(--menu-bg);
    }
    .captionConfig .box {
        height: 400px;
    }
</style>

