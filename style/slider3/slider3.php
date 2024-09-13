<?php

use JetBrains\PhpStorm\NoReturn;

class SliderNoTitle {
    static function itemForm($item): void {
        $item = SliderNoTitle::metaData($item->toObject());
        if($item->captionKey != 'none') {
            $captionKey = $item->captionKey;
            $caption = SliderNoTitleHtml::getCaptions($captionKey, $item->id);
        }

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

        Plugin::view('slider', 'admin/slider3/item-form', [
            'item' => $item,
            'form' => $form,
            'caption_key' => $captionKey ?? '',
            'caption' => $caption ?? '',
        ]);
    }
    static function itemSave($item, \SkillDo\Http\Request $request): int|array|SKD_Error {

        $galleryItem = [
            'id'    => $item->id,
            'value' => $request->input('value')
        ];

        $galleryItemMeta = [
            'name'          => $request->input('name'),
            'url'           => $request->input('url'),
            'captionKey'    => $request->input('captionKey'),
        ];

        $galleryItemMeta['caption'] = [];

        if(have_posts($request->input('caption'))) {
            $galleryItemMeta['caption'] = $request->input('caption');
        }

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
    static function scriptAdmin(): void
    {
        Plugin::view('slider', 'admin/slider3/item-script');
    }
    static function metaData($item): object {
        $option = [
            'url'           => GalleryItem::getMeta($item->id, 'url', true),
            'name'          => GalleryItem::getMeta($item->id, 'name', true),
            'captionKey'    => GalleryItem::getMeta($item->id, 'captionKey', true),
        ];
        if(!Language::isDefault()) {
            $name = GalleryItem::getMeta($item->id, 'name_'.Language::current(), true);
            if(!empty($name)) $option['name'] = $name;
        }
        return (object)array_merge((array)$item, $option);
    }
    static function render($items, $slider, $options = null): void {
        SliderNoTitleHtml::render($items, $slider, $options);
    }
}

class SliderNoTitleHtml {

    static string $path = SLIDER_PATH.'style/slider3/';

    static function render($items, $slider, $options = null): void {

        $options = (is_array($options)) ? $options : [];

        $options = array_merge(['numberItem' => count($items)], $options);

        $id = (!empty($options['id'])) ? $options['id'] : uniqid();

        foreach ($items as $key => $item) {
            $item = $item->toObject();
            $items[$key] = SliderWithTitle::metaData($item);
        }
        Plugin::view('slider', 'style/slider3/view', [
            'items'     => $items,
            'slider'    => $slider,
            'options'   => $options,
            'id'        => $id,
        ]);
        self::css();
        self::script();
    }
    static function script(): void {
        static $called = false; if ($called) return;
        Plugin::view('slider', 'style/slider3/script');
        $called = true;
    }
    static function css(): void {
        static $calledCss = false; if ($calledCss) return;
        Plugin::view('slider', 'style/slider3/css');
        $calledCss = true;
    }
    static function getCaptions($captionKey = '', $itemId = 0): array {
        $captions = [
            'caption1' => [ 'label' => 'Caption 1' ],
        ];
        if(!empty($captionKey) && !empty($captions[$captionKey])) {
            if(!empty($itemId)) {
                $captionKeyMeta    = GalleryItem::getMeta($itemId, 'captionKey', true);
                if($captionKey == $captionKeyMeta) $caption = GalleryItem::getMeta($itemId, 'caption', true);
            }
            include self::$path.'captions/'.$captionKey.'/config.php';
            return $captions[$captionKey];
        }
        include self::$path.'captions/caption1/config.php';
        return $captions;
    }
    static function renderCaptions($item): string {
        if(!empty($item->captionKey) && $item->captionKey != 'none') {
            return Plugin::partial('slider', 'style/slider3/captions/'.$item->captionKey.'/html', [
                'item'     => $item,
                'caption'   => self::getCaptions($item->captionKey, $item->id),
            ]);
        }
        return '';
    }
}

class SliderNoTitleAjax {
    #[NoReturn]
    static function itemCaptionLoad(\SkillDo\Http\Request $request, $model): void
    {
        if($request->isMethod('post')) {

            $captionKey = $request->input('captionKey');

            $id = $request->input('id');

            $caption = SliderNoTitleHtml::getCaptions($captionKey, $id);

            if(!empty($caption)) {

                $result['data'] 	= '';

                $result['slider'] 	= '';

                if(file_exists(SLIDER_PATH.'views/admin/slider3/captions/'.$captionKey.'/layer_form.blade.php')) {

                    $result['data'] = Plugin::partial('slider', 'admin/slider3/captions/' . $captionKey . '/layer_form', [
                        'caption' 		=> $caption,
                        'captionKey' 	=> $captionKey
                    ]);
                }

                response()->success(trans('ajax.load.success'), $result);
            }
        }

        response()->error(trans('ajax.load.error'));
    }
}

Ajax::admin('SliderNoTitleAjax::itemCaptionLoad');