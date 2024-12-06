<?php
namespace Slider\Style1;

use Plugin;

class Caption1 extends \Slider\Caption
{
    public string $key = 'caption1';

    public function default(): array
    {
        return [
            'layer1' => [
                'text' => 'INTRODUCING',
                'color' => '#fff'
            ],
            'layer2' => [
                'color' => '#fff'
            ],
            'layer3' => [
                'text' => 'BRAND NEW FEATURES',
                'color' => '#fff'
            ]
        ];
    }

    public function form(): string
    {
        $config = $this->config();
        $form = form();
        $form->none('<h4 class="col-md-12">Layer 1</h4>');
        $form->text('caption[layer1][text]', ['label' => 'Text layer 1', 'start' => 6], $config['layer1']['text'] ?? '');
        $form->color('caption[layer1][color]', ['label' => 'Màu chữ layer 1', 'start' => 6], $config['layer1']['color'] ?? '');
        $form->none('<h4 class="col-md-12">Layer 2</h4>');
        $form->color('caption[layer2][color]', ['label' => 'Màu chữ layer 2'], $config['layer2']['color'] ?? '');
        $form->none('<h4 class="col-md-12">Layer 3</h4>');
        $form->text('caption[layer3][text]', ['label' => 'Text layer 3', 'start' => 6], $config['layer3']['text'] ?? '');
        $form->color('caption[layer3][color]', ['label' => 'Màu chữ layer 3', 'start' => 6], $config['layer3']['color'] ?? '');
        return $form->html();
    }

    public function layers(): string
    {
        return Plugin::partial('slider', 'slider1/captions/caption1-layer', $this->config());
    }
}