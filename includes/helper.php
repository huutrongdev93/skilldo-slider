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
                'class'     => \Slider\Module\Style1\Slider::class,
                'options'   => false
            ],
            'slider2' => [
                'class'     => \Slider\Module\Style2\Slider::class,
                'options'   => true
            ],
            'slider3' => [
                'class'     => \Slider\Module\Style3\Slider::class,
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