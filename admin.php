<?php

use SkillDo\Validate\Rule;

class AdminSlider {
    static function navigation(): void {
        AdminMenu::addSub('theme', 'slider', 'Slider', 'plugins?page=slider', ['callback' => 'AdminSlider::slider', 'position' => 'option']);
    }
    static function assets(): void {
        Admin::asset()->location('footer')->add('slider', Path::plugin('slider').'/assets/js/slider-script.js');
    }
    static function slider(\SkillDo\Http\Request $request): void {

        $view = $request->input('view');

        if(empty($view)) {

            $sliders = Gallery::gets(Qr::set('object_type', 'slider'));

            foreach ($sliders as $slider) {
                if(Str::isSerialized($slider->options)) {
                    $slider->options = unserialize($slider->options);
                    $slider->options = $slider->options['type'];
                }
            }

            $form = form();

            $form->setFormId('js_slider_form__add');

            $form->setIsValid(true);

            $form->setCallbackValidJs('SliderHandler.prototype.add');

            $form->text('name', [
                'label' => 'Tên Slider',
                'validations' => Rule::make()->notEmpty()
            ]);

            $options = [];

            foreach (Slider::list() as $key => $slider) {
                $options[$key] = [ 'label' => $slider['name'], 'img' => $slider['thumb']];
            }

            $form->selectImg('type', $options, [
                'label' => 'Loại Slider',
                'validations' => Rule::make()->notEmpty()
            ]);

            Plugin::view('slider', 'admin/index', [
                'sliders' => $sliders,
                'form' => $form
            ]);
        }
        else if($view == 'detail') {

            $id = (int)$request->input('id');

            $slider         = Gallery::get(Qr::set('id', $id)->where('object_type', 'slider'));

            if(Str::isSerialized($slider->options)) {
                $slider->options = unserialize($slider->options);
                $slider->options = $slider->options['type'];
            }

            $items  = GalleryItem::gets(Qr::set('group_id', $id)->where('object_type', 'slider')->orderBy('order'));

            foreach ($items as $key => $item) {

                $item->thumb = 'https://www.shorttermprograms.com/images/other/no-image.png';

                if ((is_null($item->type) || $item->type == 'youtube' || $item->type == 'image') && !empty($item->value)) {
                    $item->thumb = Template::imgLink($item->value, 'medium');
                }
                if (($item->type == 'video') && !empty($item->value)) {
                    $item->thumb = 'https://www.theme-junkie.com/wp-content/uploads/wordpress-background-video.png';
                }

                $items[$key] = $item;
            }

            $sliderClass    = Slider::list($slider->options.'.class');

            Plugin::view('slider', 'admin/detail', [
                'id' => $id,
                'slider' => $slider,
                'items' => $items,
                'sliderClass' => $sliderClass,
            ]);
        }
    }
}

add_action('init', 'AdminSlider::navigation');
add_action('admin_init', 'AdminSlider::assets');