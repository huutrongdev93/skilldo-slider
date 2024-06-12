<?php
class SliderWithTitle {
    static function options($id) {
        $sliderOptions = Metadata::get('slider', $id, 'options', true);
        if(!have_posts($sliderOptions)) $sliderOptions = [];
        $sliderOptions['sliderTxtType'] = (isset($sliderOptions['sliderTxtType'])) ? $sliderOptions['sliderTxtType'] : 'in-slider';
        $sliderOptions['sliderTxtBg'] = (!empty($sliderOptions['sliderTxtBg'])) ? $sliderOptions['sliderTxtBg'] : 'rgba(0,0,0,0.5)';
        $sliderOptions['sliderTxtColor'] = (!empty($sliderOptions['sliderTxtColor'])) ? $sliderOptions['sliderTxtColor'] : '#fff';
        $sliderOptions['sliderTxtActive'] = (!empty($sliderOptions['sliderTxtActive'])) ? $sliderOptions['sliderTxtActive'] : 'var(--theme-color)';
        $sliderOptions['sliderTxtBgActive'] = (!empty($sliderOptions['sliderTxtBgActive'])) ? $sliderOptions['sliderTxtBgActive'] : $sliderOptions['sliderTxtBg'];
        $sliderOptions['sliderTxtFontSize'] = (!empty($sliderOptions['sliderTxtFontSize'])) ? $sliderOptions['sliderTxtFontSize'] : '14';
        return $sliderOptions;
    }
    static function optionsForm($slider): void {
        $options = Metadata::get('slider', $slider->id, 'options', true);

		$sliderTxtType = [
			'out-slider' => 'Dưới slider',
			'in-slider' => 'Trong slider'
		];

		$sliderTxtFontSize = ['10' => '10', '11' => '11', '13' => '13',  '14' => '14', '15' => '15', '16' => '16', '17' => '17', '18' => '18', '20' => '20',  '25' => '25', '30' => '30'];

        $form = form();
        $form->select('sliderTxtType', $sliderTxtType, ['start' => 15,'label' => 'Kiểu tiêu đề slider'], (empty($options['sliderTxtType'])) ? 'in-slider' : $options['sliderTxtType']);
        $form->color('sliderTxtBg', ['start' => 15,'label' => 'Màu nền thumb'], (empty($options['sliderTxtBg'])) ? '' : $options['sliderTxtBg']);
        $form->color('sliderTxtColor', ['start' => 15,'label' => 'Màu chữ thumb'], (empty($options['sliderTxtColor'])) ? '' : $options['sliderTxtColor']);
        $form->color('sliderTxtBgActive', ['start' => 15,'label' => 'Màu nền thumb (active)'], (empty($options['sliderTxtBgActive'])) ? '' : $options['sliderTxtBgActive']);
        $form->color('sliderTxtActive', ['start' => 15,'label' => 'Màu chữ thumb (active)'], (empty($options['sliderTxtActive'])) ? '' : $options['sliderTxtActive']);
        $form->tab('sliderTxtFontSize', $sliderTxtFontSize, [
	        'label' => 'Cỡ chữ',
        ], (empty($options['sliderTxtFontSize'])) ? '14' : $options['sliderTxtFontSize']);

        $form->html(false);
    }
    static function optionsSave($slider, \SkillDo\Http\Request $request): bool {
        $sliderOptions = [
            'sliderTxtType' => $request->input('sliderTxtType'),
            'sliderTxtBg' => $request->input('sliderTxtBg'),
            'sliderTxtColor' => $request->input('sliderTxtColor'),
            'sliderTxtActive' => $request->input('sliderTxtActive'),
            'sliderTxtBgActive' => $request->input('sliderTxtBgActive'),
            'sliderTxtFontSize' => $request->input('sliderTxtFontSize'),
        ];
        Metadata::update('slider', $slider->id, 'options', $sliderOptions);
        return true;
    }
    static function itemForm($item): void {

        $item = SliderWithTitle::metaData($item);

        $form = form();

        $form->file('value', ['label' => 'Ảnh hoặc video'], $item->value);

        $form->text('name', ['label' => 'Tiêu đề', 'note' => 'Dùng làm alt hình ảnh'], $item->name);

        foreach (Language::list() as $key => $lang) {
            if($key == Language::default()) continue;
            $name = 'name_'.$key;
            $form->text($name, ['label' => 'Tiêu đề ('.$lang['label'].')'], (!empty($item->$name)) ? $item->$name : '');
        }

        $form->text('url', ['label' => 'Liên kết'], $item->url);

        $form = apply_filters('admin_slider_item_form_background', $form, $item);

        Plugin::view('slider', 'admin/slider2/item-form', [
            'item' => $item,
            'form' => $form,
        ]);
    }
    static function itemSave($item, \SkillDo\Http\Request $request): int|array|SKD_Error {

        $galleryItem = [
            'id'    => $item->id,
            'value' => $request->input('value')
        ];

        $galleryItemMeta = [
            'name'=> $request->input('name'),
            'url' => $request->input('url'),
        ];

        foreach (Language::list() as $key => $lang) {
            if($key == Language::default()) continue;
            $name = 'name_'.$key;
            $galleryItemMeta[$name] = $request->input($name);
        }

        $errors = GalleryItem::insert($galleryItem);

        if(!is_skd_error($errors)) {

            foreach ($galleryItemMeta as $meta_key => $meta_value) {
                GalleryItem::updateMeta($item->id, $meta_key, $meta_value);
            }
        }

        return $errors;
    }
    static function metaData($item): object {
        $option = [
            'url'   => GalleryItem::getMeta($item->id, 'url', true),
            'name'  => GalleryItem::getMeta($item->id, 'name', true),
        ];
        if(!Language::isDefault()) {
            $name = GalleryItem::getMeta($item->id, 'name_'.Language::current(), true);
            if(!empty($name)) $option['name'] = $name;
        }
        return (object)array_merge((array)$item, $option);
    }
    static function render($items, $slider, $options = null): void {
        SliderWithTitleHtml::render($items, $slider, $options);
    }
}

class SliderWithTitleHtml {
    static function render($items, $slider, $options = null): void {
        $sliderOptions = SliderWithTitle::options($slider->id);

        $options = (is_array($options)) ? $options : [];

        $options = array_merge(['numberItem' => count($items)], $options);

        $id = (!empty($options['id'])) ? $options['id'] : uniqid();

        foreach ($items as $key => $item) {
            $items[$key] = SliderWithTitle::metaData($item);
        }

        Plugin::view('slider', 'style/slider2/view', [
            'id'            => $id,
            'sliderOptions' => $sliderOptions,
            'options'       => $options,
            'items'         => $items,
            'slider'        => $slider,
        ]);
        self::css();
        self::script();
    }
    static function script(): void {
        static $called = false; if ($called) return;
        Plugin::view('slider', 'style/slider2/script');
        $called = true;
    }
    static function css(): void {
        static $calledCss = false; if ($calledCss) return;
        Plugin::view('slider', 'style/slider2/css');
        $calledCss = true;
    }
}