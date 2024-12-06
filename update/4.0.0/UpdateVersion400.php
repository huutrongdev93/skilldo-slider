<?php
namespace Slider\Update;

use SkillDo\Model\GalleryItem;
use Storage;
use Str;

class UpdateVersion400
{
    protected array $structure = [
        'style',
        'views/admin/slider1/captions/caption1',
        'views/admin/slider1/captions/caption2',
        'views/admin/slider1/captions/caption3',
        'views/admin/slider1/captions/caption4',
        'views/admin/slider1/captions/caption5',
        'views/admin/slider1/form-caption.blade.php',
        'views/admin/slider1/item-form.blade.php',
        'views/admin/slider1/demo.blade.php',
        'views/admin/slider2/item-form.blade.php',
        'views/admin/slider3/captions/caption1',
        'views/admin/slider3/form-caption.blade.php',
        'views/admin/slider3/item-script.blade.php',
        'views/style/slider1',
        'views/style',
        'admin.php',
        'ajax.php',
        'thumb.png',
    ];

    public function database(): void
    {
        $galleries = \SkillDo\Model\Gallery::where('object_type','slider')->get();

        if(have_posts($galleries))
        {
            foreach($galleries as $gallery)
            {
                if(Str::isSerialized($gallery->options))
                {
                    $gallery->options = unserialize($gallery->options);
                }

                $type = !empty($gallery->options['type']) ? $gallery->options['type'] : $gallery->options;

                if($type == 'slider1') {

                    $items = GalleryItem::where('group_id', $gallery->id)->where('object_type', 'slider')->get();

                    if (have_posts($items))
                    {
                        foreach ($items as $item)
                        {
                            $transition = [
                                'effect' => GalleryItem::getMeta($item->id, 'data_transition', true),
                                'slot' => GalleryItem::getMeta($item->id, 'data_slotamount', true),
                                'speed' => GalleryItem::getMeta($item->id, 'data_masterspeed', true),
                            ];
                            GalleryItem::updateMeta($item->id, 'transition', $transition);
                            GalleryItem::deleteMeta($item->id, 'data_transition');
                            GalleryItem::deleteMeta($item->id, 'data_slotamount');
                            GalleryItem::deleteMeta($item->id, 'data_masterspeed');
                        }
                    }
                }
            }
        }
    }

    public function structure(): void
    {
        $storages = Storage::disk('plugin');

        foreach ($this->structure as $file)
        {
            $file = 'slider/'.$file;

            if($storages->has($file))
            {
                if($storages->directoryExists($file))
                {
                    $storages->deleteDirectory($file);
                }
                else {
                    $storages->delete($file);
                }
            }
        }
    }

    public function run(): void
    {
        $this->database();
        $this->structure();
    }
}