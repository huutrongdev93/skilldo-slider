<?php
namespace Slider\Style1;

use Plugin;

class Transition5
{
    public string $key = 'premium';

    public array $config;

    public function __construct()
    {
        $this->config = $this->default();
    }

    public function default(): array
    {
        return [
            'effect' => '3dcurtain-horizontal',
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
        ];

        $form->none('<h4 class="col-md-12">Hiệu ứng</h4>');
        $form->select2('transition[effect]', $transitionEffectList, ['label' => 'Hiệu ứng chuyển cảnh'], $config['effect'] ?? '');
        return $form->html();
    }
}