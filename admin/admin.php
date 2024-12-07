<?php

use SkillDo\Validate\Rule;
use Slider\Update\Updater;

class SliderAdmin
{
    static function navigation(): void
    {
        AdminMenu::addSub('theme', 'slider', 'Slider', 'plugins/slider', ['callback' => 'SliderAdmin::slider', 'position' => 'option']);
    }

    static function assets(): void
    {
        Admin::asset()->location('footer')->add('slider', SLIDER_PATH.'/assets/js/slider-script.js');
    }

    static function slider(\SkillDo\Http\Request $request): void
    {
        $view = $request->input('view');

        if(empty($view))
        {
            static::index($request);
        }
        else if($view == 'detail')
        {
            static::detail($request);
        }
    }

    static function index(\SkillDo\Http\Request $request): void
    {
        $form = form();

        $form->setFormId('js_slider_form__add');

        $form->setIsValid(true);

        $form->setCallbackValidJs('sliderIndex.add');

        $form->text('name', [
            'label' => 'Tên Slider',
            'validations' => Rule::make()->notEmpty()
        ]);

        $options = [];

        foreach (\Helper\Slider::list() as $key => $slider) {
            $options[$key] = [
                'label' => slider($key)->name,
                'img'   => Image::plugin('slider', slider($key)->thumb)->link(),
            ];
        }

        $form->selectImg('type', $options, [
            'label' => 'Loại Slider',
            'validations' => Rule::make()->notEmpty()
        ]);

        Plugin::view('slider', 'admin/index', ['form' => $form]);
    }

    static function detail(\SkillDo\Http\Request $request): void
    {
        $id = (int)$request->input('id');

        $slider = Gallery::where('id', $id)->where('object_type', 'slider')->first();

        if(!empty($slider))
        {
            if(Str::isSerialized($slider->options)) {
                $slider->options = unserialize($slider->options);
            }

            $slider->options = !empty($slider->options['type']) ? $slider->options['type'] : $slider->options;

            $items  = GalleryItem::where('group_id', $id)
                ->where('object_type', 'slider')
                ->orderBy('order')
                ->orderByDesc('created')
                ->get();

            foreach ($items as $key => $item) {

                $item->thumb = Image::plugin('slider', 'assets/images/no-image.png')->link();

                if ((empty($item->type) || $item->type == 'youtube' || $item->type == 'image') && !empty($item->value))
                {
                    $item->thumb = Image::medium($item->value)->link();
                }
                if (($item->type == 'video') && !empty($item->value))
                {
                    $item->thumb = Image::plugin('slider', 'assets/images/background-video.png')->link();
                }

                $items[$key] = $item;
            }

            Plugin::view('slider', 'admin/detail', [
                'id'        => $id,
                'slider'    => $slider,
                'items'     => $items,
                'sliderClass' => slider($slider->options),
            ]);
        }
        else {
            Admin::view('404');
        }
    }
}

if(!request()->ajax())
{
    add_action('admin_init', 'SliderAdmin::navigation');

    add_action('admin_init', 'SliderAdmin::assets');

    if(Plugin::getCheckUpdate('slider') !== SLIDER_VERSION)
    {
        $updater = new Updater();

        $updater->checkForUpdates();
    }
}