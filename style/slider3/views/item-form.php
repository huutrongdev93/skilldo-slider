<div role="tabpanel">
    <ul class="nav nav-tabs" role="tablist">
        <li><a href="#bg" class="active" role="tab" data-bs-toggle="tab">Background</a></li>
        <li><a href="#caption" role="caption" data-bs-toggle="tab">Captions</a> </li>
    </ul>
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active m-2" id="bg">
            <div id="bg_type_image">
                <?php
                $Form = new FormBuilder();
                $Form->add('value', 'file', ['label' => 'Ảnh hoặc video'], $item->value);
                $Form->add('name', 'text', ['label' => 'Tiêu đề'], $item->name);
                foreach (Language::list() as $key => $lang) {
                    if($key == Language::default()) continue;
                    $name = 'name_'.$key;
                    $Form->add($name, 'text', ['label' => 'Tiêu đề ('.$lang['label'].')'], (!empty($item->$name)) ? $item->$name : '');
                }
                $Form->add('url', 'text', ['label' => 'Liên kết'], $item->url);
                $Form = apply_filters('admin_slider_item_form_background', $Form, $item);
                $Form->html(false);
                ?>
            </div>
        </div>
        <!-- Caption -->
        <div role="tabpanel" class="tab-pane m-2" id="caption">
            <div class="d-flex">
                <div class="captionList"  style="width: 15%;">
                    <ul class="mb-0 jsCaptionList" role="tablist" style="background-color: var(--content-bg);">
                        <li class="captionListItem">
                            <input class="captionListInput" type="radio" name="captionKey" value="none" id="layer_none" <?php echo (empty($item->captionKey)) ? 'checked' : '';?>>
                            <label class="captionListLabel" for="layer_none">Không sử dụng</label>
                        </li>
                        <?php foreach (SliderNoTitleHtml::getCaptions() as $capKey => $captionValue) { ?>
                            <li class="captionListItem">
                                <input class="captionListInput" type="radio" name="captionKey" value="<?php echo $capKey;?>" id="layer_<?php echo $capKey;?>" <?php echo ($item->captionKey == $capKey) ? 'checked' : '';?>>
                                <label class="captionListLabel" for="layer_<?php echo $capKey;?>" data-key="<?php echo $capKey;?>" data-id="<?php echo $item->id;?>"><?php echo $captionValue['label'];?></label>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
                <div class="captionConfig scrollbar" id="jsCaptionConfigContent">
                    <?php if($item->captionKey != 'none') {
                        if(file_exists(SliderNoTitleHtml::$path.'captions/'.$item->captionKey.'/layer_form.php')) {
                            include_once SliderNoTitleHtml::$path.'captions/'.$item->captionKey.'/layer_form.php';
                        }
                    } ?>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="button text-right">
            <button class="btn btn-green"><?php echo Admin::icon('save');?> Lưu</button>
        </div>
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
        background-color: var(--menu-bg); color:#fff;
    }
    .captionConfig {
        width:calc(100% - 15%);
        padding:20px;
        height: 400px;
        overflow-y: auto;
        border:2px solid var(--menu-bg);
    }

</style>

