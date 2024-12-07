<?php
namespace Slider\Module;

class SliderCaption
{
    public function __construct(public string $key, public string $label, public $caption)
    {
        $this->key = $key;

        $this->label = $label;

        $this->caption = $caption;
    }
}