<?php
namespace Slider\Module\Style1;

use Language;
use Plugin;
use SkillDo\Model\GalleryItem;
use Url;

class Slider
{
    public string $name = 'Slider 1';

    public string $thumb = 'assets/images/thumb-slider1.png';

    protected string $path = __DIR__. '/';

    public array $items = [];

    static bool $loadAssets = false;

    static bool $loadScript = false;

    public function item($item = []): SliderItem
    {
        $this->items[$item->id] = new SliderItem($item);

        return $this->items[$item->id];
    }

    public function adminScript(): void
    {
        Plugin::view('slider', 'admin/slider1/script');
    }

    public function render($items, $slider, $options = null): void
    {
        if(!static::$loadAssets) {
            Plugin::view('slider', 'slider1/assets');
            static::$loadAssets = true;
        }

        $options = (is_array($options)) ? $options : [];

        $options = array_merge(['delay' => 3000, 'fullScreen' => 'on', 'hideThumbs' => 10], $options);

        foreach ($items as $item)
        {
            $this->item($item);
        }

        $id = uniqid();

        Plugin::view('slider', 'slider1/view', [
            'slider'    => $slider,
            'items'     => $this->items,
            'options'   => $options,
            'id'        => $id
        ]);

        Plugin::view('slider', 'slider1/script', ['id' => $id]);
    }
}

class SliderItem
{
    public array $captions;

    public array $transitions;

    public ?SliderCaption $caption = null;

    public ?SliderTransition $transition = null;

    public function __construct(public $item)
    {
        $this->captions = [
            'caption1' => new SliderCaption('caption1', 'Caption 1', new Caption1),
            'caption2' => new SliderCaption('caption2', 'Caption 2', new Caption2),
            'caption3' => new SliderCaption('caption3', 'Caption 3', new Caption3),
            'caption4' => new SliderCaption('caption4', 'Caption 4', new Caption4),
            'caption5' => new SliderCaption('caption5', 'Caption 5', new Caption5),
        ];

        $this->transitions = [
            'fade' => new SliderTransition('fade', 'Flat fade transitions', new Transition1),
            'zoom' => new SliderTransition('zoom', 'Flat zoom transitions', new Transition2),
            'parallax' => new SliderTransition('parallax', 'Flat parallax transitions', new Transition3),
            'slide' => new SliderTransition('slide', 'Flat slide transitions', new Transition4),
            'premium' => new SliderTransition('premium', 'Flat premium transitions', new Transition5),
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

            if(empty($this->item->transition_key) || !isset($this->transitions[$this->item->transition_key]))
            {
                $this->item->transition_key = 'fade';
            }

            $this->transition = $this->transitions[$this->item->transition_key];

            $transitionConfig = GalleryItem::getMeta($this->item->id, 'transition', true);

            $this->transition->setConfig($transitionConfig);
        }
    }

    public function caption($key)
    {
        return $this->captions[$key] ?? null;
    }

    public function transition($key)
    {
        return $this->transitions[$key] ?? null;
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

        return Plugin::partial('slider', 'admin/slider1/form', [
            'form'      => $form,
            'item'      => $this->item,
            'captions'  => $this->captions,
            'caption'   => $this->caption ?? null,
            'transitions'   => $this->transitions,
            'transition'    => $this->transition ?? null,
        ]);
    }

    public function save(\SkillDo\Http\Request $request): void
    {
        $this->item->value = $request->input('value');

        $itemMeta = [
            'name'=> $request->input('name'),
            'url' => $request->input('url'),
            'caption_key'       => $request->input('caption_key'),
            'transition_key'    => $request->input('transition_key'),
        ];

        $itemMeta['caption'] = [];

        if(have_posts($request->input('caption'))) {
            $itemMeta['caption'] = $request->input('caption');
        }

        foreach (Language::list() as $key => $lang) {
            if($key == Language::default()) continue;
            $name = 'name_'.$key;
            $itemMeta[$name] = $request->input($name);
        }

        $itemMeta['transition'] = [];

        if(have_posts($request->input('transition'))) {
            $itemMeta['transition'] = $request->input('transition');
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
        $this->item->transition_key     = GalleryItem::getMeta($this->item->id, 'transition_key', true);
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

            return Plugin::partial('slider', 'slider1/item', [
                'item' => $item,
                'caption' => $this->caption ?? null,
            ]);
        }

        return null;
    }

}

class SliderCaption
{
    public function __construct(public string $key, public string $label, public $caption)
    {
        $this->key = $key;

        $this->label = $label;

        $this->caption = $caption;
    }

    public function form()
    {
        return $this->caption->form();
    }

    public function setConfig($config): void
    {
        $this->caption->setConfig($config);
    }

    public function layers(): string
    {
        return $this->caption->layers();
    }

    public function demo(): string
    {
        return Plugin::partial('slider', 'admin/slider1/captions/caption-demo', [
            'layers' => $this->caption->layers(),
            'image' => \Image::plugin('slider', 'assets/slider1/images/bg1.jpg')->attributes([
                'data-bgfit' => "cover",
                'data-bgposition' => "left top",
                'data-bgrepeat' => "no-repeat",
            ])->html(),
        ]);
    }
}

class SliderTransition
{
    public function __construct(public string $key, public string $label, public $transition)
    {
        $this->key = $key;

        $this->label = $label;

        $this->transition = $transition;
    }

    public function form(): string
    {
        $form = $this->transition->form();

        return Plugin::partial('slider', 'admin/slider1/transitions/form', [
            'form' => $form,
            'config' => $this->transition->config(),
        ]);
    }

    public function setConfig($config): void
    {
        $this->transition->setConfig($config);
    }

    public function demo(): string
    {
        return Plugin::partial('slider', 'admin/slider1/transitions/transition-demo', [
            'config' => $this->transition->config(),
            'image1' => \Image::plugin('slider', 'assets/slider1/images/bg1.jpg')->attributes([
                'data-bgfit' => "cover",
                'data-bgposition' => "left top",
                'data-bgrepeat' => "no-repeat",
            ])->html(),
            'image2' => \Image::plugin('slider', 'assets/slider1/images/bg2.jpg')->attributes([
                'data-bgfit' => "cover",
                'data-bgposition' => "left top",
                'data-bgrepeat' => "no-repeat",
            ])->html(),
        ]);
    }
}