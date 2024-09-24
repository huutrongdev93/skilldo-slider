<?php

use JetBrains\PhpStorm\NoReturn;
use SkillDo\DB;
use SkillDo\Model\ThemeMenuItem;

class AdminAjaxSlider {
    #[NoReturn]
    static function add(\SkillDo\Http\Request $request, $model): void {

        if($request->isMethod('post')) {

            $name = $request->input('name');

            $type = $request->input('type');

            $data = [
                'name'          => $name,
                'options'       => ['type' => $type],
                'object_type'   => 'slider'
            ];

            $id = Gallery::insert($data);

            if(!is_skd_error($id)) {

                response()->success(trans('ajax.add.success'));
            }
        }

        response()->error(trans('ajax.add.error'));
    }

    #[NoReturn]
    static function delete(\SkillDo\Http\Request $request, $model): void {

        if($request->isMethod('post')) {

            $id = $request->input('id');

            DB::table('group')->where('id', $id)->delete();

            ThemeMenuItem::where('menu_id', $id)->remove();

            response()->success(trans('ajax.delete.success'));
        }

        response()->error(trans('ajax.delete.error'));
    }
    #[NoReturn]
    static function optionsLoad(\SkillDo\Http\Request $request, $model): void
    {

        if($request->isMethod('post')) {

            $id = (int)$request->input('id');

            $slider = Gallery::whereKey($id)->where('object_type', 'slider')->first();

            if(have_posts($slider)) {

                $slider->options = (Str::isSerialized($slider->options)) ? unserialize($slider->options) : $slider->options;

                $type = !empty($slider->options['type']) ? $slider->options['type'] : $slider->options;

                if(empty($type)) {
                    response()->error(trans('slider.ajax.option.load.error'));
                }

                $sliderType = Slider::list($type);

                if(empty($sliderType)) {

                    response()->error(trans('slider.ajax.option.load.error'));
                }

                ob_start();

                $sliderType['class']::optionsForm($slider);

                $result = ob_get_contents();

                ob_clean();

                response()->success(trans('ajax.load.success'), $result);
            }
        }

        response()->error(trans('ajax.load.error'));
    }
    #[NoReturn]
    static function optionsSave(\SkillDo\Http\Request $request, $model): void
    {
        if($request->isMethod('post')) {

            $id = (int)$request->input('id');

            $slider = Gallery::whereKey($id)->where('object_type', 'slider')->first();

            if(empty($slider)) {
                response()->error(trans('slider.ajax.option.save.error'));
            }
            $slider->options = (Str::isSerialized($slider->options)) ? unserialize($slider->options) : $slider->options;

            $type = !empty($slider->options['type']) ? $slider->options['type'] : $slider->options;

            if(empty($type)) {
                response()->error(trans('slider.ajax.option.load.error'));
            }

            $sliderType = Slider::list($type);

            if(empty($sliderType)) {

                response()->error(trans('slider.ajax.option.load.error'));
            }

            $error = $sliderType['class']::optionsSave($slider, $request);

            if(!is_skd_error($error)) {

                \SkillDo\Cache::delete('gallery_', true);

                response()->success(trans('ajax.save.success'));
            }
        }

        response()->error(trans('ajax.save.error'));
    }
    #[NoReturn]
    static function itemAdd(\SkillDo\Http\Request $request, $model): void
    {

        if($request->isMethod('post')) {

            $post = $request->input();

            if(have_posts($post)) {

                //Lấy id slider
                $id = (int)$request->input('sliderId');

                $gallery = Gallery::whereKey($id)->where('object_type', 'slider')->first();

                if(have_posts($gallery)) {

                    $id = GalleryItem::insert([
                        'group_id'      => $id,
                        'object_type'   => 'slider'
                    ]);

                    if($id) {

                        \SkillDo\Cache::delete('gallery_', true);

                        response()->success(trans('ajax.add.success'));
                    }
                }
            }
        }

        response()->error(trans('ajax.add.error'));
    }
    #[NoReturn]
    static function itemLoad(\SkillDo\Http\Request $request, $model): void
    {
        if($request->isMethod('post')) {

            $id = (int)$request->input('id');

            $sliderType = $request->input('sliderType');

            if(Str::isSerialized($sliderType)) {
                $sliderType = unserialize($sliderType);
                $sliderType = $sliderType['type'];
            }

            $slider = Slider::list($sliderType);

            if(empty($slider)) {

                response()->error(trans('slider.ajax.option.load.error'));
            }

            $item = GalleryItem::get($id);

            if(have_posts($item)) {

                ob_start();

                $slider['class']::itemForm($item);

                $result = ob_get_contents();

                ob_clean();

                response()->success(trans('ajax.load.success'), $result);
            }
        }

        response()->error(trans('ajax.load.error'));
    }
    #[NoReturn]
    static function itemSave(\SkillDo\Http\Request $request, $model): void
    {
        if($request->isMethod('post')) {

            $id = (int)$request->input('id');

            $sliderType = $request->input('type');

            if(Str::isSerialized($sliderType)) {
                $sliderType = unserialize($sliderType);
                $sliderType = $sliderType['type'];
            }

            $slider = Slider::list($sliderType);

            if(empty($slider)) {

                response()->error(trans('slider.ajax.option.load.error'));
            }

            $item = GalleryItem::get($id);

            if(have_posts($item)) {

                $error = $slider['class']::itemSave($item, $request);

                if(!is_skd_error($error)) {

                    \SkillDo\Cache::delete('gallery_', true);

                    response()->success(trans('ajax.save.success'));
                }
            }
        }

        response()->error(trans('ajax.save.error'));
    }

    #[NoReturn]
    static function itemSort(\SkillDo\Http\Request $request, $model): void
    {
        if($request->isMethod('post')) {

            $slider_item_order = $request->input('slider_item_order', ['type' => 'int']);

            if(have_posts($slider_item_order)) {

                foreach ($slider_item_order as $id => $order) {
                    $model->table('galleries');
                    $model->where('id', $id)->update(['order' => $order]);
                }

                \SkillDo\Cache::delete('gallery_', true);

                response()->success(trans('ajax.update.success'));
            }
        }

        response()->error(trans('ajax.update.error'));
    }
    #[NoReturn]
    static function itemDelete(\SkillDo\Http\Request $request, $model): void
    {
        if($request->isMethod('post')) {

            $id = (int)$request->input('id');

            $item = GalleryItem::get($id);

            if(have_posts($item)) {

                $error = GalleryItem::delete($id);

                if(!is_skd_error($error)) {

                    \SkillDo\Cache::delete('gallery_', true);

                    response()->success(trans('ajax.delete.success'));
                }
            }
        }

        response()->error(trans('ajax.delete.error'));
    }
}
Ajax::admin('AdminAjaxSlider::add');
Ajax::admin('AdminAjaxSlider::delete');
Ajax::admin('AdminAjaxSlider::optionsLoad');
Ajax::admin('AdminAjaxSlider::optionsSave');
Ajax::admin('AdminAjaxSlider::itemAdd');
Ajax::admin('AdminAjaxSlider::itemLoad');
Ajax::admin('AdminAjaxSlider::itemSave');
Ajax::admin('AdminAjaxSlider::itemSort');
Ajax::admin('AdminAjaxSlider::itemDelete');