<?php

use JetBrains\PhpStorm\NoReturn;

class SliderRevolution {
    static string $path = SLIDER_PATH.'style/slider1/';

    static function itemForm($item): void {

        $item = SliderRevolution::metaData($item);

        if($item->caption_key != 'none') {
            $caption_key = $item->caption_key;
            $caption = SliderRevolutionHtml::getCaptions($caption_key, $item->id);
        }

        $form = form();

        $form->file('value', ['label' => 'Ảnh hoặc video'], $item->value);

        $form->text('name', ['label' => 'Tiêu đề', 'note' => 'Dùng làm alt hình ảnh'], $item->name);

        foreach (Language::list() as $key => $lang) {
            if($key == Language::default()) continue;
            $name = 'name_'.$key;
            $form->text($name, ['label' => 'Tiêu đề ('.$lang['label'].')'], (!empty($item->$name)) ? $item->$name : '');
        }

        $form->text('url', ['label' => 'Liên kết'], $item->url);

        $form = apply_filters('admin_slider_item_form_background', $form, $item);

        SliderRevolutionHtml::assets();

        SliderRevolution::assetsEditor();

		Plugin::view('slider', 'admin/slider1/item-form', [
            'form' => $form,
            'item' => $item,
            'animations' => SliderRevolution::animation(),
            'caption_key' => $caption_key ?? '',
            'caption' => $caption ?? '',
		]);
    }

    static function itemSave($item, \SkillDo\Http\Request $request): int|array|SKD_Error {

        $galleryItem = [
            'id'    => $item->id,
            'value' => $request->input('value')
        ];

        $galleryItemMeta = [
            'name'=> $request->input('name'),
            'url' => $request->input('url'),
            'data_transition'   => $request->input('data_transition'),
            'data_slotamount'   => $request->input('data_slotamount'),
            'data_masterspeed'  => $request->input('data_masterspeed'),
            'caption_key'       => $request->input('caption_key'),
        ];

        $galleryItemMeta['caption'] = [];

        if(have_posts($request->input('caption'))) {
            $galleryItemMeta['caption'] = $request->input('caption');
        }

        foreach (Language::list() as $key => $lang) {
            if($key == Language::default()) continue;
            $name = 'name_'.$key;
            $galleryItemMeta[$name] = $request->input($name);
        }

        $errors = GalleryItem::insert($galleryItem);

        if(!is_skd_error($errors)) {

            foreach ($galleryItemMeta as $meta_key => $meta_value) {
                GalleryItem::updateMeta($item->id, $meta_key, $meta_value);
            }
        }

        return $errors;
    }

    static function metaData($item): object {

        $option = [
            'url'   => GalleryItem::getMeta($item->id, 'url', true),
            'name'  => GalleryItem::getMeta($item->id, 'name', true),
            'data_transition'   => GalleryItem::getMeta($item->id, 'data_transition', true),
            'data_slotamount'   => GalleryItem::getMeta($item->id, 'data_slotamount', true),
            'data_masterspeed'  => GalleryItem::getMeta($item->id, 'data_masterspeed', true),
            'caption_key'       => GalleryItem::getMeta($item->id, 'caption_key', true),
        ];

        if(!Language::isDefault()) {
            $name = GalleryItem::getMeta($item->id, 'name_'.Language::current(), true);
            if(!empty($name)) $option['name'] = $name;
        }

        return (object)array_merge((array)$item, $option);
    }

    static function animation( $key = '') {

        $list_anim['Fade'] = array(
            'fade'                    => 'Fade',
            'boxfade'                 => 'Fade Boxes',
            'slotfade-horizontal'     => 'Fade Slots Horizontal',
            'slotfade-vertical'       => 'Fade Slots Vertical',
            'fadefromright'           => 'Fade and Slide from Right',
            'fadefromleft'            => 'Fade and Slide from Left',
            'fadefromtop'             => 'Fade and Slide from Top',
            'fadefrombottom'          => 'Fade and Slide from Bottom',
            'fadetoleftfadefromright' => 'Fade To Left and Fade From Right',
            'fadetorightfadetoleft'   => 'Fade To Right and Fade From Left',
        );

        $list_anim['Zoom'] = array(
            'scaledownfromright'  => 'Zoom Out and Fade From Right',
            'scaledownfromleft'   => 'Zoom Out and Fade From Left',
            'scaledownfromtop'    => 'Zoom Out and Fade From Top',
            'scaledownfrombottom' => 'Zoom Out and Fade From Bottom',
            'zoomout'             => 'ZoomOut',
            'zoomin'              => 'ZoomIn',
            'slotzoom-horizontal' => 'Zoom Slots Horizontal',
            'slotzoom-vertical'   => 'Zoom Slots Vertical',
        );

        $list_anim['Parallax'] = array(
            'parallaxtoright'     => 'Parallax to Right',
            'parallaxtoleft'     => 'Parallax to Left',
            'parallaxtotop'     => 'Parallax to Top',
            'parallaxtobottom'    => 'Parallax to Bottom',
        );

        $list_anim['Slide'] = array(
            'slideup'              => 'Slide To Top',
            'slidedown'            =>'Slide To Bottom',
            'slideright'           =>'Slide To Right',
            'slideleft'            =>'Slide To Left',
            'slidehorizontal'      =>'Slide Horizontal (depending on Next/Previous)',
            'slidevertical'        =>'Slide Vertical (depending on Next/Previous)',
            'boxslide'             =>'Slide Boxes',
            'slotslide-horizontal' =>'Slide Slots Horizontal',
            'slotslide-vertical'   =>'Slide Slots Vertical',
            'curtain-1'            =>'Curtain from Left',
            'curtain-2'            =>'Curtain from Right',
            'curtain-3'            =>'Curtain from Middle',
        );

        $list_anim['Premium'] = array(
            '3dcurtain-horizontal' => '3D Curtain Horizontal',
            '3dcurtain-vertical'   => '3D Curtain Vertical',
            'cubic'                => 'Cube Vertical',
            'cubic'                => 'Cube Horizontal',
            'incube'               => 'In Cube Vertical',
            'incube-horizontal'    => 'In Cube Horizontal',
            'turnoff'              => 'TurnOff Horizontal',
            'turnoff-vertical'     => 'TurnOff Vertical',
            'papercut'             => 'Paper Cut',
            'flyin'                => 'Fly In',
            'random-static'        => 'Random Premium',
            'random'               => 'Random Flat and Premium',
        );

        return (isset($list_anim[$key])) ? $list_anim[$key] : (($key == '') ? $list_anim : []);
    }

    static function assetsEditor(): void {
        $assets = new AssetPosition('slider');
        $assets->add('slider-edit', self::$path.'src/css/navstylechange.css', ['minify' => false]);
        $assets->add('slider-edit', self::$path.'src/editor/type/fontello.css', ['minify' => false]);
        $assets->add('slider-edit', self::$path.'src/editor/editor.css', ['minify' => false]);
        $assets->add('slider-edit', self::$path.'src/css/style.css', ['minify' => false]);
        $assets->add('slider-edit', self::$path.'src/editor/editor.js', ['minify' => false]);
        $assets->styles();
        $assets->scripts();
    }

    static function assetsAdmin(): void {
		$assets = new AssetPosition('slider');
        $assets->add('tween-max', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/1.18.0/TweenMax.min.js', ['minify' => false]);
        $assets->scripts();
    }

    static function demo($slotamount = 5, $masterspeed = 700): void {

        $slotamount  = (empty($slotamount)) ? 5 : $slotamount;

        $masterspeed = (empty($masterspeed)) ? 700 : $masterspeed;

        Plugin::view('slider', 'admin/slider1/demo', [
            'slotamount' => $slotamount,
			'masterspeed' => $masterspeed,
	        'path' => self::$path
        ]);
    }

    static function render($items, $slider, $options = null): void {
        SliderRevolutionHtml::render($items, $slider, $options);
    }
}

class SliderRevolutionHtml {

    static string $path = SLIDER_PATH.'style/slider1/';

    static function render($items, $slider, $options = null): void {
        self::assets();
        $options = (is_array($options)) ? $options : [];
        $options = array_merge(['delay' => 3000, 'fullScreen' => 'on', 'hideThumbs' => 10], $options);
        Plugin::view('slider', 'style/slider1/view', [
            'options' => $options,
        ]);
        self::script();
    }

    static function item($item): string
    {
        $item = SliderRevolution::metaData($item);
        $output = '';
        if(isset($item->value) && $item->value != '') {
            $transition = 'data-transition="'.$item->data_transition.'" data-slotamount="'.$item->data_slotamount.'" data-masterspeed="'.$item->data_masterspeed.'"';
            $output .= '<li '.$transition.' data-link="'.$item->url.'">';
            if($item->type == 'youtube') {
                $output .= '<div class="tp-caption tp-fade fadeout fullscreenvideo" data-x="0" data-y="0" data-speed="1000" data-start="1100"
							data-easing="Power4.easeOut" data-endspeed="1500" data-endeasing="Power4.easeIn" data-autoplay="true" data-autoplayonlyfirsttime="false"
							data-nextslideatend="true" data-forceCover="1" data-aspectratio="16:9" data-forcerewind="on" style="z-index: 2">';
                $output .= '<iframe src="https://www.youtube.com/embed/'.Url::getYoutubeID($item->value).'?controls=0&autoplay=1" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
                $output .= '</div>';
            }
            if($item->type == 'video') {
                $output .= '<div class="tp-caption tp-fade fadeout fullscreenvideo" data-x="0" data-y="0" data-speed="1000" data-start="1100"
							data-easing="Power4.easeOut" data-endspeed="1500" data-endeasing="Power4.easeIn" data-autoplay="true" data-autoplayonlyfirsttime="false"
							data-nextslideatend="true" data-forceCover="1" data-aspectratio="16:9" data-forcerewind="on" style="z-index: 2">';
                $output .= '<video muted class="video-js vjs-default-skin" preload="none" width="100%" height="100%" poster="uploads/banne-slider-1.jpg" data-setup="{}"><source src="'.Template::imgLink($item->value).'" type="video/mp4"/></video>';

                $output .= '</div>';
            }
            if($item->type == 'image') {
                $output .= '<img src="'.Template::imgLink($item->value).'"  alt="'.$item->name.'"  data-bgfit="cover" data-bgposition="left top" data-bgrepeat="no-repeat">';
            }
            if($item->caption_key != 'none') {
                $caption = self::getCaptions($item->caption_key, $item->id);
                ob_start();
                self::caption($item->caption_key, $caption);
                $output .= ob_get_contents();
                ob_clean();
            }
            $output .= '</li >';
        }
        return $output;
    }
    static function script(): void {
        static $called = false; if ($called) return;
        Plugin::view('slider', 'style/slider1/script');
        $called = true;
    }
    static function assets(): void {
        static $calledAssets = false; if ($calledAssets) return;
        Plugin::view('slider', 'style/slider1/lib', ['path' => self::$path]);
        $calledAssets = true;
    }
    static function getCaptions($caption_key = '', $item_id = 0): array {
        $captions = [
            'caption1' => [ 'label' => 'Caption 1' ],
            'caption2' => [ 'label' => 'Caption 2' ],
            'caption3' => [ 'label' => 'Caption 3' ],
            'caption4' => [ 'label' => 'Caption 4' ],
            'caption5' => [ 'label' => 'Caption 5' ]
        ];
        if(!empty($caption_key) && !empty($captions[$caption_key])) {
            if(!empty($item_id)) {
                $caption_key_meta    = GalleryItem::getMeta($item_id, 'caption_key', true);
                if($caption_key == $caption_key_meta) $caption = GalleryItem::getMeta($item_id, 'caption', true);
            }
            include self::$path.'captions/'.$caption_key.'/config.php';
            return $captions[$caption_key];
        }
        include self::$path.'captions/caption1/config.php';
        include self::$path.'captions/caption2/config.php';
        return $captions;
    }
    static function caption($key, $caption): void {
        if(!empty($key)) {
            Plugin::view('slider', 'admin/slider1/captions/'.$key.'/layer_caption', [
				'key' => $key,
				'caption' => $caption
            ]);
        }
    }
}

class SliderRevolutionAjax {
    #[NoReturn]
    static function itemCaptionLoad(SkillDo\Http\Request $request, $model): void
    {
        if($request->isMethod('post')) {

            $caption_key = $request->input('caption_key');

            $id = $request->input('id');

            $caption = SliderRevolutionHtml::getCaptions($caption_key, $id);

            if(!empty($caption)) {

                $result['data'] 	= '';

                $result['slider'] 	= '';

                if(file_exists(SLIDER_PATH.'views/admin/slider1/captions/'.$caption_key.'/layer_form.blade.php')) {

                    $result['data'] = Plugin::partial('slider', 'admin/slider1/captions/' . $caption_key . '/layer_form', [
                        'caption' 		=> $caption,
                        'caption_key' 	=> $caption_key
                    ]);

                    $result['slider'] = Plugin::partial('slider', 'admin/slider1/form-caption', [
						'caption' 		=> $caption,
                        'caption_key' 	=> $caption_key
                    ]);
                }

                response()->success(trans('ajax.load.success'), $result);
            }
        }
        response()->error(trans('ajax.load.error'));
    }
}
Ajax::admin('SliderRevolutionAjax::itemCaptionLoad');