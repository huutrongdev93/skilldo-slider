<?php
namespace Slider\Style1;

use Plugin;

class Transition1
{
    public string $key = 'fade';

    public array $config;

    public function __construct()
    {
        $this->config = $this->default();
    }

    public function default(): array
    {
        return [
            'effect' => 'fade',
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
        ];

        $form->none('<h4 class="col-md-12">Hiệu ứng</h4>');
        $form->select2('transition[effect]', $transitionEffectList, ['label' => 'Hiệu ứng chuyển cảnh'], $config['effect'] ?? '');
        return $form->html();
    }
}