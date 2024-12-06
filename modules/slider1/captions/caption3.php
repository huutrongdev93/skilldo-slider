<?php
namespace Slider\Style1;

use Plugin;

class Caption3 extends \Slider\Caption
{
    public string $key = 'caption3';

    public function default(): array
    {
        return [
            'layer1' => [
                'text' => 'The clearest way into the Universe is through a forest wilderness.',
                'color' => '#fff'
            ],
            'layer2' => [
                'text' => 'John Muir',
                'color' => '#fff'
            ]
        ];
    }

    public function form(): string
    {
        $config = $this->config();
        $form = form();
        $form->text('caption[layer1][text]', ['label' => 'Text layer 1'], $config['layer1']['text'] ?? '');
        $form->color('caption[layer1][color]', ['label' => 'Màu chữ layer 1'], $config['layer1']['color'] ?? '');
        $form->text('caption[layer2][text]', ['label' => 'Text layer 2'], $config['layer2']['text'] ?? '');
        $form->color('caption[layer2][color]', ['label' => 'Màu chữ layer 2'], $config['layer2']['color'] ?? '');
        return $form->html();
    }

    public function layers(): string
    {
        return Plugin::partial('slider', 'slider1/captions/caption3-layer', $this->config());
    }
}