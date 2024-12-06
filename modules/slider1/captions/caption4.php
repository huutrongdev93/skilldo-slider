<?php
namespace Slider\Style1;

use Plugin;

class Caption4 extends \Slider\Caption
{
    public string $key = 'caption4';

    public function default(): array
    {
        return [
            'layer1' => ['text' => 'READY TO', 'color' => '#fff'],
            'layer2' => ['text' => 'use', 'color' => '#fff'],
            'layer3' => ['text' => 'EXAMPLES', 'color' => '#fff'],
            'layer4' => ['text' => 'CUSTOMIZED', 'color' => '#fff', 'bg' => 'rgba(0,0,0,0.5)'],
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
        $form->text('caption[layer3][text]', ['label' => 'Text layer 3'], $config['layer3']['text'] ?? '');
        $form->color('caption[layer3][color]', ['label' => 'Màu chữ layer 3'], $config['layer3']['color'] ?? '');
        $form->text('caption[layer4][text]', ['label' => 'Text layer 4'], $config['layer4']['text'] ?? '');
        $form->color('caption[layer4][color]', ['label' => 'Màu chữ layer 4'], $config['layer4']['color'] ?? '');
        $form->color('caption[layer4][bg]', ['label' => 'Màu nền layer 4'], $config['layer4']['bg'] ?? '');
        return $form->html();
    }

    public function layers(): string
    {
        return Plugin::partial('slider', 'slider1/captions/caption4-layer', $this->config());
    }
}