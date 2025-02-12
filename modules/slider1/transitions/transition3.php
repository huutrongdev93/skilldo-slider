<?php
namespace Slider\Module\Style1;

use Plugin;

class Transition3
{
    public string $key = 'parallax';

    public array $config;

    public function __construct()
    {
        $this->config = $this->default();
    }

    public function default(): array
    {
        return [
            'effect' => 'parallaxtoright',
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
                if(!isset($this->config[$key]))
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
            'parallaxtoright'   => 'Parallax to Right',
            'parallaxtoleft'    => 'Parallax to Left',
            'parallaxtotop'     => 'Parallax to Top',
            'parallaxtobottom'  => 'Parallax to Bottom',
        ];

        $form->none('<h4 class="col-md-12">Hiệu ứng</h4>');
        $form->select2('transition[effect]', $transitionEffectList, ['label' => 'Hiệu ứng chuyển cảnh'], $config['effect'] ?? '');
        return $form->html();
    }
}