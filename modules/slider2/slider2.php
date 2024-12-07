<?php
namespace Slider\Module\Style2;

use Language;
use Metadata;
use Plugin;
use SkillDo\Model\GalleryItem;

class Slider
{
    public string $name = 'Slider 2';

    public string $thumb = 'assets/images/thumb-slider2.png';

    protected string $path = __DIR__. '/';

    public array $items = [];

    public array $config = [];

    public int $id = 0;

    static bool $loadAssets = false;

    static bool $loadScript = false;

    public function item($item = []): SliderItem
    {
        $this->items[$item->id] = new SliderItem($item);

        return $this->items[$item->id];
    }

    public function setId($id): static
    {
        $this->id = $id;

        return $this;
    }

    public function setConfig(): static
    {
        $sliderConfig = Metadata::get('slider', $this->id, 'options', true);

        if(!have_posts($sliderConfig)) $sliderConfig = [];

        $this->config['sliderTxtType'] = $sliderConfig['sliderTxtType'] ?? 'in-slider';
        $this->config['sliderTxtBg'] = (!empty($sliderConfig['sliderTxtBg'])) ? $sliderConfig['sliderTxtBg'] : 'rgba(0,0,0,0.5)';
        $this->config['sliderTxtColor'] = (!empty($sliderConfig['sliderTxtColor'])) ? $sliderConfig['sliderTxtColor'] : '#fff';
        $this->config['sliderTxtActive'] = (!empty($sliderConfig['sliderTxtActive'])) ? $sliderConfig['sliderTxtActive'] : 'var(--theme-color)';
        $this->config['sliderTxtBgActive'] = (!empty($sliderConfig['sliderTxtBgActive'])) ? $sliderConfig['sliderTxtBgActive'] : $this->config['sliderTxtBg'];
        $this->config['sliderTxtFontSize'] = (!empty($sliderConfig['sliderTxtFontSize'])) ? $sliderConfig['sliderTxtFontSize'] : '14';

        return $this;
    }

    public function config(): array
    {
        return $this->config;
    }

    public function form(): ?string
    {
        $sliderTxtType = [
            'out-slider' => 'Dưới slider',
            'in-slider' => 'Trong slider'
        ];

        $sliderTxtFontSize = ['10' => '10', '11' => '11', '13' => '13',  '14' => '14', '15' => '15', '16' => '16', '17' => '17', '18' => '18', '20' => '20',  '25' => '25', '30' => '30'];

        $form = form();
        $form->select('sliderTxtType', $sliderTxtType, ['start' => 4, 'label' => 'Kiểu tiêu đề slider'], $this->config['sliderTxtType']);
        $form->tab('sliderTxtFontSize', $sliderTxtFontSize, [
            'label' => 'Cỡ chữ',
            'start' => 8,
        ], $this->config['sliderTxtFontSize']);
        $form->color('sliderTxtBg', ['label' => 'Màu nền thumb', 'start' => 3], $this->config['sliderTxtBg']);
        $form->color('sliderTxtColor', ['label' => 'Màu chữ thumb', 'start' => 3], $this->config['sliderTxtColor']);
        $form->color('sliderTxtBgActive', ['start' => 3,'label' => 'Màu nền thumb (active)'], $this->config['sliderTxtBgActive']);
        $form->color('sliderTxtActive', ['start' => 3,'label' => 'Màu chữ thumb (active)'], $this->config['sliderTxtActive']);

        return $form->html();
    }

    public function save(\SkillDo\Http\Request $request): void
    {
        $sliderOptions = [
            'sliderTxtType' => $request->input('sliderTxtType'),
            'sliderTxtBg' => $request->input('sliderTxtBg'),
            'sliderTxtColor' => $request->input('sliderTxtColor'),
            'sliderTxtActive' => $request->input('sliderTxtActive'),
            'sliderTxtBgActive' => $request->input('sliderTxtBgActive'),
            'sliderTxtFontSize' => $request->input('sliderTxtFontSize'),
        ];
        Metadata::update('slider', $this->id, 'options', $sliderOptions);
    }

    public function render($items, $slider, $options = []): void
    {
        $id = (!empty($options['id'])) ? $options['id'] : uniqid();

        $this->setId($slider->id)->setConfig();

        if(is_array($options) && !empty($options))
        {
            $this->config =  array_merge($this->config, $options);
        }

        $this->config['numberItem'] =  count($items);

        foreach ($items as $key => $item)
        {
            $items[$key] = $this->item($item)->item;
        }

        Plugin::view('slider', 'slider2/view', [
            'id'        => $id,
            'slider'    => $slider,
            'items'     => $items,
            'options'   => $this->config,
        ]);

        if(!static::$loadAssets) {
            Plugin::view('slider', 'slider2/css');
            static::$loadAssets = true;
        }

        if(!static::$loadScript) {
            Plugin::view('slider', 'slider2/script');
            static::$loadScript = true;
        }
    }
}

class SliderItem extends \Slider\Module\SliderItem
{
    public function __construct(public $item)
    {
        $this->captions = [];

        $this->item = $item;

        if(!empty($this->item->id))
        {
            $this->metaData();
        }
    }

    public function form(): string
    {
        $form = form();

        $form->file('value', ['label' => 'Ảnh hoặc video'], $this->item->value);

        $form->text('name', ['label' => 'Tiêu đề', 'note' => 'Dùng làm alt hình ảnh'], $this->item->name);

        foreach (Language::list() as $key => $lang) {
            if($key == Language::default()) continue;
            $name = 'name_'.$key;
            $form->text($name, ['label' => 'Tiêu đề ('.$lang['label'].')'], (!empty($this->item->$name)) ? $this->item->$name : '');
        }

        $form->text('url', ['label' => 'Liên kết'], $this->item->url);

        $form = apply_filters('admin_slider_item_form_background', $form, $this->item);

        return Plugin::partial('slider', 'admin/slider2/form', [
            'form'      => $form,
            'item'      => $this->item,
            'captions'  => null,
            'caption'   => null,
            'transitions'   => null,
            'transition'    => null,
        ]);
    }

    public function save(\SkillDo\Http\Request $request): void
    {
        $this->item->value = $request->input('value');

        $itemMeta = [
            'name'=> $request->input('name'),
            'url' => $request->input('url'),
        ];

        foreach (Language::list() as $key => $lang) {
            if($key == Language::default()) continue;
            $name = 'name_'.$key;
            $itemMeta[$name] = $request->input($name);
        }

        $this->item->save();

        foreach ($itemMeta as $key => $value)
        {
            GalleryItem::updateMeta($this->item->id, $key, $value);
        }
    }

    public function metaData(): void
    {
        $this->item->url                = GalleryItem::getMeta($this->item->id, 'url', true);

        $this->item->name               = GalleryItem::getMeta($this->item->id, 'name', true);

        if(!Language::isDefault())
        {
            $name = GalleryItem::getMeta($this->item->id, 'name_'.Language::current(), true);

            if(!empty($name))
            {
                $this->item->name = $name;
            }
        }
    }
}

class SliderCaption extends \Slider\Module\SliderCaption
{
}

class SliderTransition extends \Slider\Module\SliderTransition
{
}