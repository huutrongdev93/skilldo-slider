<?php
namespace Slider\Module\Style1;

use Plugin;

class Caption2 extends \Slider\Module\Caption
{
    public string $key = 'caption2';

    public function default(): array
    {
        $config = [
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

        foreach (\Language::listKey() as $local)
        {
            if($local == \Language::default())
            {
                continue;
            }
            $config['layer1']['text_'.$local] = $config['layer1']['text'];
            $config['layer3']['text_'.$local] = $config['layer3']['text'];
            $config['layer4']['text_'.$local] = $config['layer4']['text'];
            $config['layer5']['text_'.$local] = $config['layer5']['text'];
            $config['layer6']['text_'.$local] = $config['layer6']['text'];
        }

        return $config;
    }

    public function form(): string
    {
        $config = $this->config();
        $form = form();
        $form->none('<h4 class="col-md-12">Layer 1</h4>');

        foreach (\Language::list() as $local => $language)
        {
            $localKey = '_'. $local;

            if($local == \Language::default())
            {
                $localKey = '';
            }

            $form->text('caption[layer1][text'.$localKey.']', [
                'label' => 'Text layer 1 ('.$language['label'].')',
            ], $config['layer1']['text'.$localKey] ?? '');
        }

        $form->color('caption[layer1][color]', ['label' => 'Màu chữ layer 1'], $config['layer1']['color'] ?? '');

        $form->none('<h4 class="col-md-12">Layer 2</h4>');

        $form->color('caption[layer2][color]', ['label' => 'Màu chữ layer 2'], $config['layer2']['color'] ?? '');

        $form->none('<h4 class="col-md-12">Layer 3</h4>');

        $form->color('caption[layer3][color]', ['label' => 'Màu chữ layer 3'], $config['layer3']['color'] ?? '');

        foreach (\Language::list() as $local => $language)
        {
            $localKey = '_'. $local;

            if($local == \Language::default())
            {
                $localKey = '';
            }

            $form->text('caption[layer3][text'.$localKey.']', [
                'label' => 'Text layer 3 ('.$language['label'].')',
            ], $config['layer3']['text'.$localKey] ?? '');
        }

        $form->none('<h4 class="col-md-12">Layer 4</h4>');
        $form->color('caption[layer4][color]', ['label' => 'Màu chữ layer 4'], $config['layer4']['color'] ?? '');
        foreach (\Language::list() as $local => $language)
        {
            $localKey = '_'. $local;

            if($local == \Language::default())
            {
                $localKey = '';
            }

            $form->text('caption[layer4][text'.$localKey.']', [
                'label' => 'Text layer 4 ('.$language['label'].')',
            ], $config['layer4']['text'.$localKey] ?? '');
        }


        $form->none('<h4 class="col-md-12">Layer 5</h4>');
        $form->color('caption[layer5][color]', ['label' => 'Màu chữ layer 5'], $config['layer5']['color'] ?? '');
        foreach (\Language::list() as $local => $language)
        {
            $localKey = '_'. $local;

            if($local == \Language::default())
            {
                $localKey = '';
            }

            $form->text('caption[layer5][text'.$localKey.']', [
                'label' => 'Text layer 5 ('.$language['label'].')',
            ], $config['layer5']['text'.$localKey] ?? '');
        }
        $form->none('<h4 class="col-md-12">Layer 6</h4>');
        $form->color('caption[layer6][color]', ['label' => 'Màu chữ layer 6'], $config['layer6']['color'] ?? '');
        foreach (\Language::list() as $local => $language)
        {
            $localKey = '_'. $local;

            if($local == \Language::default())
            {
                $localKey = '';
            }

            $form->text('caption[layer6][text'.$localKey.']', [
                'label' => 'Text layer 6 ('.$language['label'].')',
            ], $config['layer6']['text'.$localKey] ?? '');
        }
        return $form->html();
    }

    public function layers(): string
    {
        $config = $this->config();

        $local = \Language::current();

        if(\Language::default() != $local)
        {
            $config['layer1']['text'] = $config['layer1']['text_'.$local] ?? $config['layer1']['text'];
            $config['layer3']['text'] = $config['layer3']['text_'.$local] ?? $config['layer3']['text'];
            $config['layer4']['text'] = $config['layer4']['text_'.$local] ?? $config['layer4']['text'];
            $config['layer5']['text'] = $config['layer5']['text_'.$local] ?? $config['layer5']['text'];
            $config['layer6']['text'] = $config['layer6']['text_'.$local] ?? $config['layer6']['text'];
        }

        return Plugin::partial('slider', 'slider1/captions/caption2-layer', $config);
    }
}