<?php
namespace Slider\Module\Style1;

use Plugin;

class Transition4
{
    public string $key = 'slide';

    public array $config;

    public function __construct()
    {
        $this->config = $this->default();
    }

    public function default(): array
    {
        return [
            'effect' => 'slideup',
            'slot' => 5,
            'speed' => 700
        ];
    }

    public function setConfig($config): void
    {
        if(is_array($config) && have_posts($config))
        {
            foreach($config as $key => $configValue)
            {
                if(!is_array($this->config[$key]))
                {
                    continue;
                }

                if(is_string($configValue))
                {
                    $this->config[$key] = $configValue;
                    continue;
                }

                if(is_array($configValue))
                {
                    $this->config[$key] = array_merge($this->config[$key], $configValue);
                }
            }
        }
    }

    public function config(): array
    {
        return $this->config;
    }

    public function form(): string
    {
        $config = $this->config();
        $form = form();
        $transitionEffectList = [
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
        ];

        $form->none('<h4 class="col-md-12">Hiệu ứng</h4>');
        $form->select2('transition[effect]', $transitionEffectList, ['label' => 'Hiệu ứng chuyển cảnh'], $config['effect'] ?? '');
        return $form->html();
    }
}