<?php
class SliderNoTitle {
    static function itemForm($item): void {
        $item = SliderNoTitle::metaData($item);
        if($item->captionKey != 'none') {
            $captionKey = $item->captionKey;
            $caption = SliderNoTitleHtml::getCaptions($captionKey, $item->id);
        }
        include 'views/item-form.php';
    }
    static function itemSave($item): int|array|SKD_Error {

        $galleryItem = [
            'id'    => $item->id,
            'value' => Request::post('value')
        ];

        $galleryItemMeta = [
            'name'          => Request::post('name'),
            'url'           => Request::post('url'),
            'captionKey'    => Request::post('captionKey'),
        ];

        $galleryItemMeta['caption'] = [];

        if(have_posts(Request::post('caption'))) {
            $galleryItemMeta['caption'] = Request::post('caption');
        }

        foreach (Language::list() as $key => $lang) {
            if($key == Language::default()) continue;
            $name = 'name_'.$key;
            $galleryItemMeta[$name] = Request::post($name);
        }

        $errors = Gallery::insertItem($galleryItem);

        if(!is_skd_error($errors)) {

            foreach ($galleryItemMeta as $meta_key => $meta_value) {
                Gallery::updateItemMeta($item->id, $meta_key, $meta_value);
            }
        }

        return $errors;
    }
    static function metaData($item): object {
        $option = [
            'url'           => Gallery::getItemMeta($item->id, 'url', true),
            'name'          => Gallery::getItemMeta($item->id, 'name', true),
            'captionKey'    => Gallery::getItemMeta($item->id, 'captionKey', true),
        ];
        if(!Language::isDefault()) {
            $name = Gallery::getItemMeta($item->id, 'name_'.Language::current(), true);
            if(!empty($name)) $option['name'] = $name;
        }
        return (object)array_merge((array)$item, $option);
    }
    static function render($items, $slider, $options = null): void {
        SliderNoTitleHtml::render($items, $slider, $options);
    }
}

class SliderNoTitleHtml {
    static string $path = SLIDER_PATH.'style/slider3/';
    static function render($items, $slider, $options = null): void {
        $options = (is_array($options)) ? $options : [];
        $options = array_merge(['numberItem' => count($items)], $options);
        $id = (!empty($options['id'])) ? $options['id'] : uniqid();
        ?>
        <div id="sliderNoTitle_<?php echo $id;?>" class="sliderNoTitle stick-dots js_slider_title box-content slider_box" style="position: relative" data-id="<?php echo $id;?>" data-options="<?php echo htmlentities(json_encode($options));?>">
            <div class="arrow_box js_slider_title_arrow">
                <div class="prev arrow"><i class="fal fa-chevron-left"></i></div>
                <div class="next arrow"><i class="fal fa-chevron-right"></i></div>
            </div>
            <div id="js_slider_title_list_<?php echo $id;?>" class="js_slider_title_list slider_list_item owl-carousel">
                <?php foreach ($items as $item) {
                    SliderNoTitleHtml::item($item);
                } ?>
            </div>
        </div>
        <?php
        self::css();
        self::script();
    }
    static function item($item): void {
        $item = SliderNoTitle::metaData($item);
        ?>
        <div class="sliderItem">
            <a aria-label='slide' href="<?php echo $item->url;?>">
                <?php Template::img($item->value, $item->name, array('style' => 'cursor:pointer'));?>
                <?php self::renderCaptions($item);?>
            </a>
        </div>
        <?php
    }
    static function script(): void {
        static $called = false; if ($called) return;
        ?>
        <script>
            $(() => {
                $.each($('.js_slider_title'), function (index, element) {
                    let options = $(this).data('options');
                    let sliderId = $(this).data('id');
                    let sliderWidth = $(this).width();
                    let sliderHeight = Math.ceil(sliderWidth*(parseFloat(options.ratioHeight)/parseFloat(options.ratioWidth)));

                    $(this).find('.js_slider_title_list .sliderItem').css('height', sliderHeight+'px');

                    $(window).resize(function () {
                        sliderWidth = $(this).width();
                        sliderHeight = Math.ceil(sliderWidth*(parseFloat(options.ratioHeight)/parseFloat(options.ratioWidth)));
                        $(this).find('.js_slider_title_list .sliderItem').css('height', sliderHeight + 'px');
                    });

                    let sliderMain = $(this).find('.js_slider_title_list');
                    let arrowNext = $(this).find('.js_slider_title_arrow .next');
                    let arrowPrev = $(this).find('.js_slider_title_arrow .prev');

                    sliderMain.slick({
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        arrows: false,
                        fade: true,
                        autoplay: true,
                        loop:true,
                        lazyLoad: 'progressive',
                        dots: true,
                    });
                    arrowNext.click(function() {
                        sliderMain.slick('slickNext'); return false;
                    });
                    arrowPrev.click(function() {
                        sliderMain.slick('slickPrev'); return false;
                    });
                });
            });
        </script>
        <?php
        $called = true;
    }
    static function css(): void {
        static $calledCss = false; if ($calledCss) return;
        ?>
        <style>
            .sliderNoTitle .slider_list_item .item img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }
            body .sliderNoTitle .arrow {
                font-size: 30px;
                background-color:transparent!important;
                box-shadow: none;
            }
            body .sliderNoTitle .arrow i {
                text-shadow: 0 0 5px #fff;
            }
            body .sliderNoTitle .arrow:hover {
                background-color:transparent!important;
            }
            .sliderNoTitle .slick-dots {
                position: absolute;
                bottom: 25px;
                list-style: none;
                display: block;
                text-align: center;
                padding: 0;
                margin: 0;
                width: 100%;
            }
            .sliderNoTitle .slick-dots li {
                position: relative;
                display: inline-block;
                margin: 0 5px;
                padding: 0;
                cursor: pointer;
                height: 3px;
                width: 50px;
            }
            .sliderNoTitle .slick-dots li button {
                border: 0;
                display: block;
                outline: none;
                line-height: 0px;
                font-size: 0px;
                cursor: pointer;
                transition: all 0.3s ease;
                position: relative;
                background-color: white;
                opacity: 0.25;
                width: 50px;
                height: 3px;
                padding: 0;
            }
            .sliderNoTitle .slick-dots li button:before {
                display: none;
            }
            .sliderNoTitle .slick-dots li button:hover,
            .sliderNoTitle .slick-dots li button:focus {
                outline: none;opacity: 1;
            }
            .sliderNoTitle .slick-dots li.slick-active button {
                background-color: white;
                opacity: 0.75;
            }
            .sliderNoTitle .slick-dots li.slick-active button:hover,
            .sliderNoTitle .slick-dots li.slick-active button:focus {
                opacity: 1;
            }
            .sliderNoTitle .sliderItem .sliderItemCaption {
                position: absolute;
                z-index: 99;
                width: 49%; height:50%;
                display:flex;
            }
            .sliderNoTitle .sliderItem .sliderItemCaption.positionY--center {
                left:0;
                width: 100%;
                justify-content: center;
                text-align: center;
            }
            .sliderNoTitle .sliderItem .sliderItemCaption.positionY--left {
                left: 100px; text-align: left;
            }
            .sliderNoTitle .sliderItem .sliderItemCaption.positionY--right {
                right: 100px; text-align: right;
            }
            .sliderNoTitle .sliderItem .sliderItemCaption.positionX--center {
                top:0;
                height: 100%;
                align-items: center;
            }
            .sliderNoTitle .sliderItem .sliderItemCaption.positionX--top {
                top: 10%;
            }
            .sliderNoTitle .sliderItem .sliderItemCaption.positionX--bottom {
                bottom: 10%; align-items: flex-end;
            }

            .sliderNoTitle .sliderItem .sliderItemCaption .sliderItemCaption-title {
                position: relative;
                color: var(--slider-caption1-heading-color);
                font-family: var(--slider-caption1-heading-font);
                font-weight: var(--slider-caption1-heading-weight);
                font-size: var(--slider-caption1-heading-size);
                line-height: var(--slider-caption1-heading-height);
                opacity: 0;
                visibility: hidden;
                -webkit-transition: all 500ms ease;
                -o-transition: all 500ms ease;
                transition: all 500ms ease;
                -webkit-transform: translateY(-20px);
                -ms-transform: translateY(-20px);
                transform: translateY(-20px);
                text-transform: capitalize;
            }
            .sliderNoTitle .sliderItem .sliderItemCaption .sliderItemCaption-detail {
                letter-spacing: 0.04em;
                margin-top: 40px;
                /* padding-right: 15%; */
                opacity: 0;
                visibility: hidden;
                -webkit-transition: all 500ms ease;
                -o-transition: all 500ms ease;
                transition: all 500ms ease;
                -webkit-transform: translateX(-50px);
                -ms-transform: translateX(-50px);
                transform: translateX(-50px);
                color: var(--slider-caption1-des-color);
                font-family: var(--slider-caption1-des-font);
                font-weight: var(--slider-caption1-des-weight);
                font-size: var(--slider-caption1-des-size);
                line-height: var(--slider-caption1-des-height);
            }
            .sliderNoTitle .slick-current .sliderItem .sliderItemCaption .sliderItemCaption-title {
                opacity: 1;
                visibility: visible;
                -webkit-transition-delay: .3s;
                -o-transition-delay: .3s;
                transition-delay: .3s;
                -webkit-transform: translateY(0px);
                -ms-transform: translateY(0px);
                transform: translateY(0px);
            }
            .sliderNoTitle .slick-current .sliderItem .sliderItemCaption .sliderItemCaption-detail {
                opacity: 1;
                visibility: visible;
                -webkit-transition-delay: .5s;
                -o-transition-delay: .5s;
                transition-delay: .5s;
                -webkit-transform: translateX(0px);
                -ms-transform: translateX(0px);
                transform: translateX(0px);
            }
            @media(max-width:600px) {
                .sliderNoTitle .sliderItem .sliderItemCaption .sliderItemCaption-title {
                    color: var(--slider-caption1-headingM-color);
                    font-family: var(--slider-caption1-headingM-font);
                    font-weight: var(--slider-caption1-headingM-weight);
                    font-size: var(--slider-caption1-headingM-size);
                    line-height: var(--slider-caption1-headingM-height);
                }
                .sliderNoTitle .sliderItem .sliderItemCaption .sliderItemCaption-detail {
                    color: var(--slider-caption1-desM-color);
                    font-family: var(--slider-caption1-desM-font);
                    font-weight: var(--slider-caption1-desM-weight);
                    font-size: var(--slider-caption1-desM-size);
                    line-height: var(--slider-caption1-desM-height);
                }
            }
        </style>
        <?php
        $calledCss = true;
    }
    static function getCaptions($captionKey = '', $itemId = 0): array {
        $captions = [
            'caption1' => [ 'label' => 'Caption 1' ],
        ];
        if(!empty($captionKey) && !empty($captions[$captionKey])) {
            if(!empty($itemId)) {
                $captionKeyMeta    = Gallery::getItemMeta($itemId, 'captionKey', true);
                if($captionKey == $captionKeyMeta) $caption = Gallery::getItemMeta($itemId, 'caption', true);
            }
            include self::$path.'captions/'.$captionKey.'/config.php';
            return $captions[$captionKey];
        }
        include self::$path.'captions/caption1/config.php';
        return $captions;
    }
    static function renderCaptions($item): void {
        if(!empty($item->captionKey) && $item->captionKey != 'none') {
            $caption = self::getCaptions($item->captionKey, $item->id);
            include self::$path.'captions/'.$item->captionKey.'/html.php';
        }
    }
}

class SliderNoTitleAjax {
    static function itemCaptionLoad($ci, $model) {

        $result['message'] 	= 'Load dữ liệu không thành công!';

        $result['status'] 	= 'error';

        if(Request::post()) {

            $captionKey = Request::post('captionKey');

            $id = Request::post('id');

            $caption = SliderNoTitleHtml::getCaptions($captionKey, $id);

            if(!empty($caption)) {

                $result['data'] 	= '';

                $result['slider'] 	= '';

                if(file_exists(SliderNoTitleHtml::$path.'captions/'.$captionKey.'/layer_form.php')) {
                    ob_start();
                    include_once SliderNoTitleHtml::$path.'captions/'.$captionKey.'/layer_form.php';
                    $result['data'] = ob_get_contents();
                    ob_clean();
                }

                $result['status'] 	= 'success';

                $result['message'] 	= 'Cập nhật thành công';
            }
        }
        echo json_encode($result);
    }
}
Ajax::admin('SliderNoTitleAjax::itemCaptionLoad');