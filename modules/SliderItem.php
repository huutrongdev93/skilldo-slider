<?php
namespace Slider\Module;

class SliderItem
{
    public array $captions;

    public $caption = null;

    public array $transitions = [];

    public $transition = null;

    public function caption($key)
    {
        return $this->captions[$key] ?? null;
    }

    public function transition($key)
    {
        return $this->transitions[$key] ?? null;
    }
}