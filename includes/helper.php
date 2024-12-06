<?php

namespace Helper;

use Arr;

class Slider
{
    static array $slider = [];

    static function list($key = null)
    {
        $slider = [
            'slider1' => [
                'class'     => \Slider\Style1\Slider::class,
                'item'      => \Slider\Style1\SliderItem::class,
                'options'   => false
            ],
            'slider2' => [
                'class'     => \Slider\Style2\Slider::class,
                'item'      => \Slider\Style2\SliderItem::class,
                'options'   => true
            ],
            'slider3' => [
                'class'     => \Slider\Style3\Slider::class,
                'item'      => \Slider\Style3\SliderItem::class,
                'options'   => false
            ]
        ];

        if(!empty($key))
        {
            return Arr::get($slider, $key);
        }

        return apply_filters('register_slider', $slider);
    }

    static function getSlider($key)
    {
        if(array_key_exists($key, static::$slider))
        {
            return static::$slider[$key];
        }

        $class = static::list($key)['class'] ?? '';

        if(empty($class))
        {
            return null;
        }

        static::$slider[$key] = new $class;

        return static::$slider[$key];
    }
}