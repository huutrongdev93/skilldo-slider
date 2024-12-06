<?php
namespace Slider\Style3;

use Language;
use Metadata;
use Plugin;
use SkillDo\Cache;
use SkillDo\Model\GalleryItem;
use Url;

class Slider
{
    public string $name = 'Slider 3';

    public string $thumb = 'assets/images/thumb-slider3.png';

    protected string $path = __DIR__. '/';

    public array $items = [];

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

    public function adminScript(): void
    {
        Plugin::view('slider', 'admin/slider3/script');
    }

    public function render($items, $slider, $options = []): void
    {
        if(!static::$loadAssets) {
            Plugin::view('slider', 'slider3/css');
            static::$loadAssets = true;
        }

        $id = (!empty($options['id'])) ? $options['id'] : uniqid();

        foreach ($items as $key => $item)
        {
            $this->item($item);
        }

        Plugin::view('slider', 'slider3/view', [
            'id'        => $id,
            'slider'    => $slider,
            'items'     => $this->items,
            'options'   => $options,
        ]);

        if(!static::$loadScript) {
            Plugin::view('slider', 'slider3/script');
            static::$loadScript = true;
        }
    }
}

class SliderItem extends \Slider\SliderItem
{
    public function __construct(public $item)
    {
        $this->captions = [
            'caption1' => new SliderCaption('caption1', 'Caption 1', new Caption1),
        ];

        $this->item = $item;

        if(!empty($this->item->id))
        {
            $this->metaData();

            if(!empty($this->item->caption_key) && $this->item->caption_key != 'none' && isset($this->captions[$this->item->caption_key]))
            {
                $this->caption = $this->captions[$this->item->caption_key];

                $captionConfig = GalleryItem::getMeta($this->item->id, 'caption', true);

                $this->caption->setConfig($captionConfig);
            }
            else
            {
                $item->caption_key = 'none';
            }
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

        return Plugin::partial('slider', 'admin/slider3/form', [
            'form'      => $form,
            'item'      => $this->item,
            'captions'  => $this->captions,
            'caption'   => $this->caption,
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
            'caption_key'       => $request->input('caption_key'),
        ];

        foreach (Language::list() as $key => $lang) {
            if($key == Language::default()) continue;
            $name = 'name_'.$key;
            $itemMeta[$name] = $request->input($name);
        }

        $itemMeta['caption'] = [];

        if(have_posts($request->input('caption'))) {
            $itemMeta['caption'] = $request->input('caption');
        }

        $this->item->save();

        foreach ($itemMeta as $key => $value)
        {
            GalleryItem::updateMeta($this->item->id, $key, $value);
        }

        $cacheId = 'slider3_item_caption1_layers_'. $this->item->id;

        Cache::delete($cacheId);
    }

    public function metaData(): void
    {
        $this->item->url                = GalleryItem::getMeta($this->item->id, 'url', true);

        $this->item->name               = GalleryItem::getMeta($this->item->id, 'name', true);

        $this->item->caption_key        = GalleryItem::getMeta($this->item->id, 'caption_key', true);

        if(!Language::isDefault())
        {
            $name = GalleryItem::getMeta($this->item->id, 'name_'.Language::current(), true);

            if(!empty($name))
            {
                $this->item->name = $name;
            }
        }
    }

    public function render(): ?string
    {
        $item = $this->item->toObject();

        if(!empty($item->value)) {

            $type = $item->type;

            if(empty($item->type))
            {
                $type = 'image';

                if(Url::isYoutube($item->value))
                {
                    $type = 'youtube';
                }
                else
                {
                    $extension = pathinfo($item->value, PATHINFO_EXTENSION);

                    if(in_array($extension, ['mp4', 'webm', 'webma', 'flv', 'avi', 'mpge', 'mkv', 'm4p', 'm4v', 'm4a', 'amv', 'mov'])) {
                        $type = 'video';
                    }
                }
            }

            $item->type = $type;

            $this->caption->setItemId($item->id);

            return Plugin::partial('slider', 'slider3/item', [
                'item' => $item,
                'caption' => $this->caption->caption ?? null,
            ]);
        }

        return null;
    }
}

class SliderCaption extends \Slider\SliderCaption
{
    public function form()
    {
        return $this->caption->form();
    }

    public function setConfig($config): void
    {
        $this->caption->setConfig($config);
    }

    public function setItemId($id): void
    {
        $this->caption->setItemId($id);
    }

    public function config(): array
    {
        return $this->caption->config();
    }

    public function demo(): string
    {
        $this->caption->setItemId('demo');

        return Plugin::partial('slider', 'admin/slider3/captions/caption-demo', [
            'layers' => $this->caption->layers(),
            'image1' => \Image::plugin('slider', 'assets/slider1/images/bg1.jpg')->html(),
            'image2' => \Image::plugin('slider', 'assets/slider1/images/bg2.jpg')->html(),
        ]);
    }
}