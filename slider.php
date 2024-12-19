<?php

use SkillDo\DB;

const SLIDER_NAME = 'slider';

const SLIDER_PATH = 'views/plugins/'.SLIDER_NAME;

const SLIDER_VERSION = '4.1.1';

class Slider {

    private string $name = 'Slider';

    function __construct() {}

    public function active(): void {}

    public function uninstall(): void
    {
        DB::table('group')->where('object_type', 'slider')->delete();
        DB::table('galleries')->where('object_type', 'slider')->delete();
    }

    static function render($sliderId, $options = null): void {

        $slider = Gallery::where('id', $sliderId)->where('object_type', 'slider')->first();

        if(have_posts($slider)) {

            $slider->options = (Str::isSerialized($slider->options)) ? unserialize($slider->options) : $slider->options;

            $type = !empty($slider->options['type']) ? $slider->options['type'] : $slider->options;

            if(!empty($type)) {

                $sliderClass = slider($type);

                if (!empty($sliderClass)) {

                    $items = GalleryItem::gets(Qr::set('group_id', $sliderId)->where('object_type', 'slider')->orderBy('order'));

                    if (have_posts($items)) {
                        if(!Device::isGoogleSpeed()) {
                            $sliderClass->render($items, $slider, $options);
                        }
                        else {
                            echo Image::source($items[0]->value, 'slider')->attributes(['css' => 'width:100%'])->html();
                        }
                    }
                }
            }
        }
    }
}

include_once 'autoload/autoload.php';