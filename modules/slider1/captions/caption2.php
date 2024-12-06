<?php
namespace Slider\Style1;

use Plugin;

class Caption2 extends \Slider\Caption
{
    public string $key = 'caption2';

    public function default(): array
    {
        return [
            'layer1' => [
                'text' => 'animate',
                'color' => '#fff'
            ],
            'layer2' => [
                'color' => '#fff'
            ],
            'layer3' => [
                'text' => 'CHARACTERS',
                'color' => '#fff'
            ],
            'layer4' => [
                'text' => 'SINGLE WORDS',
                'color' => '#fff'
            ],
            'layer5' => [
                'text' => 'LINES',
                'color' => '#fff'
            ],
            'layer6' => [
                'text' => 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam.',
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
        $form->color('caption[layer2][color]', ['label' => 'Màu chữ layer 2', 'start' => 6], $config['layer2']['color'] ?? '');
        $form->text('caption[layer3][text]', ['label' => 'Text layer 3', 'start' => 6], $config['layer3']['text'] ?? '');
        $form->none('<h4 class="col-md-12">Layer 3</h4>');
        $form->color('caption[layer3][color]', ['label' => 'Màu chữ layer 3'], $config['layer3']['color'] ?? '');
        $form->none('<h4 class="col-md-12">Layer 4</h4>');
        $form->text('caption[layer4][text]', ['label' => 'Text layer 4', 'start' => 6], $config['layer4']['text'] ?? '');
        $form->color('caption[layer4][color]', ['label' => 'Màu chữ layer 4', 'start' => 6], $config['layer4']['color'] ?? '');
        $form->none('<h4 class="col-md-12">Layer 5</h4>');
        $form->text('caption[layer5][text]', ['label' => 'Text layer 5', 'start' => 6], $config['layer5']['text'] ?? '');
        $form->color('caption[layer5][color]', ['label' => 'Màu chữ layer 5', 'start' => 6], $config['layer5']['color'] ?? '');
        $form->none('<h4 class="col-md-12">Layer 6</h4>');
        $form->text('caption[layer6][text]', ['label' => 'Text layer 6', 'start' => 6], $config['layer6']['text'] ?? '');
        $form->color('caption[layer6][color]', ['label' => 'Màu chữ layer 6', 'start' => 6], $config['layer6']['color'] ?? '');
        return $form->html();
    }

    public function layers(): string
    {
        return Plugin::partial('slider', 'slider1/captions/caption2-layer', $this->config());
    }
}