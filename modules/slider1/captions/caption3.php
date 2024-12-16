<?php
namespace Slider\Module\Style1;

use Plugin;

class Caption3 extends \Slider\Module\Caption
{
    public string $key = 'caption3';

    public function default(): array
    {
        $config = [
            'layer1' => [
                'text' => 'The clearest way into the Universe is through a forest wilderness.',
                'color' => '#fff'
            ],
            'layer2' => [
                'text' => 'John Muir',
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
            $config['layer2']['text_'.$local] = $config['layer2']['text'];
        }

        return $config;
    }

    public function form(): string
    {
        $config = $this->config();
        $form = form();
        $form->color('caption[layer1][color]', ['label' => 'Màu chữ layer 1'], $config['layer1']['color'] ?? '');
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

        $form->color('caption[layer2][color]', ['label' => 'Màu chữ layer 2'], $config['layer2']['color'] ?? '');

        foreach (\Language::list() as $local => $language)
        {
            $localKey = '_'. $local;

            if($local == \Language::default())
            {
                $localKey = '';
            }

            $form->text('caption[layer2][text'.$localKey.']', [
                'label' => 'Text layer 2 ('.$language['label'].')',
            ], $config['layer2']['text'.$localKey] ?? '');
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
            $config['layer2']['text'] = $config['layer2']['text_'.$local] ?? $config['layer2']['text'];
        }

        return Plugin::partial('slider', 'slider1/captions/caption3-layer', $config);
    }
}