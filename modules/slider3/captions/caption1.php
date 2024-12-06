<?php
namespace Slider\Style3;

use Plugin;
use SkillDo\Cache;
use ThemeCssBuild;

class Caption1 extends \Slider\Caption
{
    public string $key = 'caption1';

    public function default(): array
    {
        return [
            'position' => [
                'x' => 'center',
                'y' => 'center'
            ],
            'heading' => [
                'txt'           => 'Jungle Safari Resort',
                'color'         => [
                    'active' => 'color',
                    'color' => '#fff'
                ],
                'fontWeight'    => 'bold',
                'fontSize'      => 30,
                'fontFamily'    => 0,
                'lineHeight'    => 40,
            ],
            'description' => [
                'txt'           => 'Food indulgence in mind, come next door and sate your desires with our ever changing internationally and seasonally.',
                'color'         => [
                    'active' => 'color',
                    'color' => '#fff'
                ],
                'fontWeight'    => '400',
                'fontSize'      => [],
                'fontFamily'    => 0,
                'lineHeight'    => 30,
            ],
        ];
    }

    public function form(): string
    {
        $config = $this->config();
        $form = form();
        $form->none('<h4 class="col-md-12">Layer 1</h4>');
        $form->tab('caption[position][x]', ['top' => 'Trên', 'center' => 'Giữa', 'bottom' => 'Dưới'], ['label' => 'Canh lề dọc', 'start' => 6], $config['position']['x'] ?? '');
        $form->tab('caption[position][y]', ['left' => 'Trái', 'center' => 'Giữa', 'right' => 'Phải'], ['label' => 'Canh lề ngang', 'start' => 6], $config['position']['y'] ?? '');
        $form->none('<h4 class="col-md-12">Layer 2</h4>');
        $form->textBuilding('caption[heading]', ['label' => 'Tiêu đề'], $config['heading'] ?? '');
        $form->none('<h4 class="col-md-12">Layer 3</h4>');
        $form->textBuilding('caption[description]', ['label' => 'Mô tả'], $config['description'] ?? '');
        return $form->html();
    }

    public function layers(): string
    {
        $config = $this->config();

        $id = $this->itemId();

        $cacheId = 'slider3_item_caption1_layers_'. $id;

        if($id == 'demo' || !Cache::has($cacheId))
        {
            $style = new ThemeCssBuild('.sliderNoTitle .sliderItem .sliderItemCaption.'.$cacheId);

            $style->cssStyle('.sliderItemCaption-wrapper .sliderItemCaption-title', [
                'data'  => $config['heading'],
                'style' => 'cssText',
                'options' => [
                    'desktop' => 'css',
                    'tablet'  => 'cssTablet',
                    'mobile'  => 'cssMobile',
                ]
            ]);

            $style->cssStyle('.sliderItemCaption-wrapper .sliderItemCaption-detail', [
                'data'  => $config['description'],
                'style' => 'cssText',
                'options' => [
                    'desktop' => 'css',
                    'tablet'  => 'cssTablet',
                    'mobile'  => 'cssMobile',
                ]
            ]);

            $config['css'] = $style->build();

            Cache::save($cacheId, $config['css'], TIME_CACHE);
        }

        if(empty($config['css']) && Cache::has($cacheId))
        {
            $config['css'] = Cache::get($cacheId);
        }

        $config['captionClassId'] = $cacheId;

        return Plugin::partial('slider', 'slider3/captions/caption1-layer', $config);
    }
}