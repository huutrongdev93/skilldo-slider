<?php
namespace Slider\Module\Style1;

use Plugin;

class Caption5 extends \Slider\Module\Caption
{
    public string $key = 'caption5';

    public function default(): array
    {
        $config = [
            'layer1' => ['text' => 'Faster & More', 'color' => 'red'],
            'layer2' => ['text' => 'Slider Revolution is the highly acclaimed<br/> slide-based displaying solution, thousands of<br/> businesses, theme developers and everyday<br/> people use and love!', 'color' => '#000'],
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
        return Plugin::partial('slider', 'slider1/captions/caption5-layer', $config);
    }
}