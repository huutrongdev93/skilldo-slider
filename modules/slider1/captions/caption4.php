<?php
namespace Slider\Module\Style1;

use Plugin;

class Caption4 extends \Slider\Module\Caption
{
    public string $key = 'caption4';

    public function default(): array
    {
        $config = [
            'layer1' => ['text' => 'READY TO', 'color' => '#fff'],
            'layer2' => ['text' => 'use', 'color' => '#fff'],
            'layer3' => ['text' => 'EXAMPLES', 'color' => '#fff'],
            'layer4' => ['text' => 'CUSTOMIZED', 'color' => '#fff', 'bg' => 'rgba(0,0,0,0.5)'],
        ];

        foreach (\Language::listKey() as $local)
        {
            if($local == \Language::default())
            {
                continue;
            }
            $config['layer1']['text_'.$local] = $config['layer1']['text'];
            $config['layer2']['text_'.$local] = $config['layer2']['text'];
            $config['layer3']['text_'.$local] = $config['layer3']['text'];
            $config['layer4']['text_'.$local] = $config['layer4']['text'];
        }

        return $config;
    }

    public function form(): string
    {
        $config = $this->config();
        $form = form();
        $form->none('<h4 class="col-md-12">Layer 1</h4>');
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


        $form->none('<h4 class="col-md-12">Layer 2</h4>');
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
        $form->color('caption[layer4][color]', ['label' => 'Màu chữ layer 4', 'start' => 6], $config['layer4']['color'] ?? '');
        $form->color('caption[layer4][bg]', ['label' => 'Màu nền layer 4', 'start' => 6], $config['layer4']['bg'] ?? '');
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
            $config['layer3']['text'] = $config['layer3']['text_'.$local] ?? $config['layer3']['text'];
            $config['layer4']['text'] = $config['layer4']['text_'.$local] ?? $config['layer4']['text'];
        }
        return Plugin::partial('slider', 'slider1/captions/caption4-layer',$config);
    }
}