<?php
namespace Slider\Module\Style1;

use Plugin;

class Caption5 extends \Slider\Module\Caption
{
    public string $key = 'caption5';

    public function default(): array
    {
        return [
            'layer1' => ['text' => 'Faster & More', 'color' => 'red'],
            'layer2' => ['text' => 'Slider Revolution is the highly acclaimed<br/> slide-based displaying solution, thousands of<br/> businesses, theme developers and everyday<br/> people use and love!', 'color' => '#000'],
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
        return Plugin::partial('slider', 'slider1/captions/caption5-layer', $this->config());
    }
}