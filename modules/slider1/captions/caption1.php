<?php
namespace Slider\Module\Style1;

use Plugin;
use SkillDo\Model\Language;

class Caption1 extends \Slider\Module\Caption
{
    public string $key = 'caption1';

    public function default(): array
    {
        $config = [
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

        foreach (\Language::listKey() as $local)
        {
            if($local == \Language::default())
            {
                continue;
            }

            $config['layer1']['text_'.$local] = $config['layer1']['text'];
            $config['layer3']['text_'.$local] = $config['layer3']['text'];
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

        $form->color('caption[layer3][color]', ['label' => 'Màu chữ layer 3'], $config['layer3']['color'] ?? '');

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
        }

        return Plugin::partial('slider', 'slider1/captions/caption1-layer', $config);
    }
}