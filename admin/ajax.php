<?php

use SkillDo\DB;

class SliderAdminAjax
{
    static function load(SkillDo\Http\Request $request): void
    {
        $sliders = Gallery::where('object_type', 'slider')->get();

        $sliderRender = '';

        if(have_posts($sliders))
        {
            foreach ($sliders as $slider)
            {
                if(Str::isSerialized($slider->options))
                {
                    $slider->options = unserialize($slider->options);
                }

                $slider->options = !empty($slider->options['type']) ? $slider->options['type'] : $slider->options;

                $sliderType = \Helper\Slider::list($slider->options);

                $sliderRender .= Plugin::partial('slider', 'admin/slider-item', [
                    'slider' => $slider,
                    'sliderType' => $sliderType
                ]);
            }
        }

        response()->success(trans('ajax.load.success'), [
            'slider' => $sliderRender
        ]);
    }

    static function sliderAdd(\SkillDo\Http\Request $request): void {

        $name = $request->input('name');

        $type = $request->input('type');

        $data = [
            'name'          => $name,
            'options'       => ['type' => $type],
            'object_type'   => 'slider'
        ];

        $id = Gallery::insert($data);

        if(is_skd_error($id))
        {
            response()->error(trans('ajax.add.error'));
        }

        $slider = Gallery::whereKey($id)->where('object_type', 'slider')->first();

        $slider->options = ['type' => $type];

        $sliderType = \Helper\Slider::list($type);

        $slider = Plugin::partial('slider', 'admin/slider-item', [
            'slider' => $slider,
            'sliderType' => $sliderType
        ]);

        response()->success(trans('ajax.add.success'), ['slider' => $slider]);
    }

    static function delete(\SkillDo\Http\Request $request): void
    {
        $id = $request->input('data');

        Gallery::whereKey($id)->where('object_type', 'slider')->delete();

        response()->success(trans('ajax.delete.success'));
    }

    static function optionsLoad(\SkillDo\Http\Request $request): void
    {
        $id = (int)$request->input('id');

        $slider = Gallery::whereKey($id)->where('object_type', 'slider')->first();

        if(have_posts($slider)) {

            $slider->options = (Str::isSerialized($slider->options)) ? unserialize($slider->options) : $slider->options;

            $type = !empty($slider->options['type']) ? $slider->options['type'] : $slider->options;

            if(empty($type)) {
                response()->error(trans('slider.ajax.option.load.error'));
            }

            $sliderType = slider($type);

            if(empty($sliderType))
            {
                response()->error(trans('slider.ajax.option.load.error'));
            }

            $sliderType->setId($slider->id)->setConfig();

            response()->success(trans('ajax.load.success'), [
                'html' => $sliderType->form(),
            ]);
        }

        response()->error(trans('ajax.load.error'));
    }

    static function optionsSave(\SkillDo\Http\Request $request): void
    {
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

        $sliderObject = slider($type);

        if(empty($sliderObject)) {

            response()->error(trans('slider.ajax.option.load.error'));
        }

        $sliderObject->setId($slider->id)->save($request);

        \SkillDo\Cache::delete('gallery_', true);

        response()->success(trans('ajax.save.success'));
    }
}

Ajax::admin('SliderAdminAjax::load');
Ajax::admin('SliderAdminAjax::sliderAdd');
Ajax::admin('SliderAdminAjax::delete');
Ajax::admin('SliderAdminAjax::optionsLoad');
Ajax::admin('SliderAdminAjax::optionsSave');


class SliderItemAdminAjax
{
    static function add(\SkillDo\Http\Request $request): void
    {
        //Lấy id slider
        $sliderId = (int)$request->input('sliderId');

        $sliderType = $request->input('sliderType');

        $gallery = Gallery::whereKey($sliderId)->where('object_type', 'slider')->first();

        if(!have_posts($gallery))
        {
            response()->error(trans('ajax.add.error'));
        }

        $id = GalleryItem::create([
            'group_id'      => $sliderId,
            'object_type'   => 'slider'
        ]);

        if(is_skd_error($id))
        {
            response()->error(trans('ajax.add.error'));
        }

        \SkillDo\Cache::delete('gallery_', true);

        $item = Plugin::partial('slider', 'admin/detail/item', [
            'item' => (object)[
                'id'        => $id,
                'group_id'  => $sliderId,
                'thumb'     => Image::plugin('slider', 'assets/images/no-image.png')->link(),
                'order'     => 0,
            ],
            'id'    => $id,
            'type'  => $sliderType
        ]);

        response()->success(trans('ajax.add.success'), [
            'item' => $item
        ]);
    }

    static function info(\SkillDo\Http\Request $request): void
    {
        $id = (int)$request->input('id');

        $sliderType = $request->input('sliderType');

        if(Str::isSerialized($sliderType))
        {
            $sliderType = unserialize($sliderType);
            $sliderType = $sliderType['type'];
        }

        $slider = slider($sliderType);

        if(empty($slider))
        {
            response()->error(trans('slider.ajax.option.load.error'));
        }

        $item = GalleryItem::find($id);

        if(have_posts($item))
        {
            $html = $slider->item($item)->form();

            response()->success(trans('ajax.load.success'), $html);
        }
    }

    static function sort(\SkillDo\Http\Request $request): void
    {
        $slider_item_order = $request->input('slider_item_order');

        if(have_posts($slider_item_order)) {

            foreach ($slider_item_order as $id => $order)
            {
                DB::table('galleries')
                    ->where('id', $id)
                    ->update(['order' => $order]);
            }

            \SkillDo\Cache::delete('gallery_', true);

            response()->success(trans('ajax.update.success'));
        }
    }

    static function captionLoad(\SkillDo\Http\Request $request): void
    {
        $id = (int)$request->input('id');

        $item = GalleryItem::find($id);

        if(!have_posts($item))
        {
            response()->error(trans('ajax.load.error'));
        }

        $sliderType = $request->input('type');

        $captionKey = $request->input('key');

        $caption = slider($sliderType)->item($item)->caption($captionKey);

        if(empty($caption))
        {
            response()->error(trans('slider.ajax.option.load.error'));
        }

        response()->success(trans('ajax.load.success'), [
            'form' => $caption->form(),
            'demo' => $caption->demo()
        ]);
    }

    static function transitionLoad(\SkillDo\Http\Request $request): void
    {
        $id = (int)$request->input('id');

        $item = GalleryItem::find($id);

        if(!have_posts($item))
        {
            response()->error(trans('ajax.load.error'));
        }

        $sliderType = $request->input('type');

        $transitionKey = $request->input('key');

        $transition = slider($sliderType)->item($item)->transition($transitionKey);

        if(empty($transition))
        {
            response()->error(trans('slider.ajax.option.load.error'));
        }

        response()->success(trans('ajax.load.success'), [
            'form' => $transition->form(),
            'demo' => $transition->demo()
        ]);
    }

    static function save(\SkillDo\Http\Request $request): void
    {
        $id = (int)$request->input('id');

        $sliderType = $request->input('type');

        if(Str::isSerialized($sliderType))
        {
            $sliderType = unserialize($sliderType);
            $sliderType = $sliderType['type'];
        }

        $slider = slider($sliderType);

        if(empty($slider))
        {
            response()->error(trans('slider.ajax.option.load.error'));
        }

        $item = GalleryItem::find($id);

        if(have_posts($item))
        {
            $slider->item($item)->save($request);

            response()->success(trans('ajax.save.success'));
        }

        response()->error(trans('ajax.save.error'));
    }

    static function delete(\SkillDo\Http\Request $request): void
    {
        $id = $request->input('data');

        GalleryItem::whereKey($id)->delete();

        response()->success(trans('ajax.delete.success'));
    }
}

Ajax::admin('SliderItemAdminAjax::add');
Ajax::admin('SliderItemAdminAjax::info');
Ajax::admin('SliderItemAdminAjax::sort');
Ajax::admin('SliderItemAdminAjax::captionLoad');
Ajax::admin('SliderItemAdminAjax::transitionLoad');
Ajax::admin('SliderItemAdminAjax::save');
Ajax::admin('SliderItemAdminAjax::delete');