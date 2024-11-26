<?php

use SkillDo\DB;

const SLIDER_NAME = 'slider';

define('SLIDER_PATH', Path::plugin(SLIDER_NAME).'/');

class Slider {

    private string $name = 'Slider';

    function __construct() {}

    public function active(): void {}

    public function uninstall(): void {
        DB::table('group')->where('object_type', 'slider')->delete();
        DB::table('galleries')->where('object_type', 'slider')->delete();
    }

    static function list($key = null) {
        $slider = [
            'slider1' => [
                'name'  => 'Slider 1',
                'thumb' => SLIDER_PATH.'style/slider1/thumb.png',
                'class' => 'SliderRevolution',
                'options' => false
            ],
            'slider2' => [
                'name' => 'Slider 2',
                'thumb' => SLIDER_PATH.'style/slider2/thumb.png',
                'class' => 'SliderWithTitle',
                'options' => true
            ],
            'slider3' => [
                'name' => 'Slider 3',
                'thumb' => SLIDER_PATH.'style/slider3/thumb.png',
                'class' => 'SliderNoTitle',
                'options' => false
            ]
        ];

        if($key != null) return Arr::get($slider, $key);

        return apply_filters('register_slider', $slider);
    }

    static function render($sliderId, $options = null): void {
        $slider = Gallery::get(Qr::set('id', $sliderId)->where('object_type', 'slider'));
        if(have_posts($slider)) {

            $slider->options = (Str::isSerialized($slider->options)) ? unserialize($slider->options) : $slider->options;

            $type = !empty($slider->options['type']) ? $slider->options['type'] : $slider->options;

            if(!empty($type)) {

                $sliderClass = Slider::list( $type . '.class');

                if (class_exists($sliderClass)) {

                    $items = GalleryItem::gets(Qr::set('group_id', $sliderId)->where('object_type', 'slider')->orderBy('order'));

                    if (have_posts($items)) {
                        if(!Device::isGoogleSpeed()) {
                            $sliderClass::render($items, $slider, $options);
                        }
                        else {
                            Template::img($items[0]->value, 'slider', ['css' => 'width:100%']);
                        }
                    }
                }
            }
        }
    }
}
include_once 'ajax.php';
include_once 'admin.php';
include_once 'style/slider1/slider1.php';
include_once 'style/slider2/slider2.php';
include_once 'style/slider3/slider3.php';