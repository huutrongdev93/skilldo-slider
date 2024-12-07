<?php
namespace Slider\Module\Style1;

use Plugin;

class Transition2
{
    public string $key = 'zoom';

    public array $config;

    public function __construct()
    {
        $this->config = $this->default();
    }

    public function default(): array
    {
        return [
            'effect' => 'scaledownfromright',
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
            'scaledownfromright'  => 'Zoom Out and Fade From Right',
            'scaledownfromleft'   => 'Zoom Out and Fade From Left',
            'scaledownfromtop'    => 'Zoom Out and Fade From Top',
            'scaledownfrombottom' => 'Zoom Out and Fade From Bottom',
            'zoomout'             => 'ZoomOut',
            'zoomin'              => 'ZoomIn',
            'slotzoom-horizontal' => 'Zoom Slots Horizontal',
            'slotzoom-vertical'   => 'Zoom Slots Vertical',
        ];

        $form->none('<h4 class="col-md-12">Hiệu ứng</h4>');
        $form->select2('transition[effect]', $transitionEffectList, ['label' => 'Hiệu ứng chuyển cảnh'], $config['effect'] ?? '');
        return $form->html();
    }
}