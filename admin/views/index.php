<div class="ui-title-bar__group">
	<h1 class="ui-title-bar__title">Slider</h1>
	<div class="ui-title-bar__action"><button class="btn btn-blue" data-fancybox="" data-src="#hidden-content"><?php echo Admin::icon('add');?> Thêm mới slider</button></div>
</div>
<div class="box list-sliders">
    <div class="box-content p-2">
        <div class="sliders-list">
            <?php foreach ($sliders as $key => $slider): $sliderType = Slider::list($slider->options); ?>
                <a href="<?php echo Url::admin('plugins?page=slider&view=detail&id='.$slider->id);?>">
                    <div class="item">
                        <span class="slider-first-image" style="background-size: inherit; background-repeat: repeat;;background-image:url(<?php echo Path::plugin('slider').'/assets/images/Transparent_Background.webp';?>) "></span>
                        <span class="slider-title-wrapper"><span class="slider-title"><?= $slider->name;?></span></span>
                        <div class="slider-button">
                            <button class="btn btn-red js_slider__delete" data-id="<?php echo $slider->id;?>" style="position: relative;top:5px;"><?php echo Admin::icon('delete');?></button>
                            <?php if($sliderType['options'] == 'true') {?>
                            <button class="btn btn-green js_slider__options" data-id="<?php echo $slider->id;?>" style="position: relative;top:5px;"><i class="fa-thin fa-gear"></i></button>
                            <?php } ?>
                        </div>
                    </div>
                </a>
            <?php endforeach ?>
        </div>
    </div>
</div>
<div class="box js_slider_options_box" style="display: none">
	<div class="box-content p-2">
		<div id="sliderOptionsModal">
			<form action="" id="js_slider_form__options" autocomplete="off">
				<div class="row" id="sliderOptionsModal_content"></div>
				<div class="text-right">
					<button class="btn-icon btn-blue"><?php echo Admin::icon('save');?> Lưu</button>
				</div>
			</form>
		</div>
	</div>
</div>

<!-- popup thêm menu -->
<div style="display: none; padding:0px; min-width: 400px;" id="hidden-content">
    <div class="box">
        <h4 class="header" style="margin:0 0 10px 0; border-radius: 0;">THÊM SLIDER</h4>
        <form id="js_slider_form__add" autocomplete="off">
            <div class="m-3">
                <?php echo Admin::loading();?>
                <?php echo FormBuilder::render(['name' => 'name', 'label' => 'Tên Slider', 'value'=>'','type' => 'text']);?>
                <?php
                $options = [];
                foreach (Slider::list() as $key => $slider) {
                    $options[$key] = [ 'label' => $slider['name'], 'img' => $slider['thumb']];
                }
                echo FormBuilder::render(['name' => 'type', 'label' => 'Loại Slider', 'value'=>'', 'type' => 'select-img', 'options' => $options])
                ?>
            </div>
            <div class="slider-type"></div>
            <div class="text-right" style="margin-bottom: 10px">
                <button class="btn-icon btn-blue"><i class="fa fa-plus-square"></i>Thêm</button>
            </div>
        </form>
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
        top: 0px: left:0px;
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