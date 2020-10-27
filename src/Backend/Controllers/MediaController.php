<?php

namespace VnCoder\Backend\Controllers;

use VnCoder\Models\VnMedia;
use Barryvdh\Debugbar\Facade as Debugbar;
use Barryvdh\Debugbar\LaravelDebugbar;

class MediaController extends BackendController
{
    public function Index_Action()
    {
        $this->metaData->title = 'Media Manager';
        $this->setData['medias'] = VnMedia::getMedia($this->uid, $this->is_root, 50);
        return $this->views('media.index');
    }

    public function Loader_Action()
    {
        debugbar_off();
        $action = getParam('action', 'input');
        $medias = VnMedia::getMedia($this->uid, $this->is_root, 17);
        return view('backend::core.media', ['medias' => $medias , 'action' => $action]);
    }

    public function Loader_Action_Submit()
    {
        debugbar_off();
        if ($this->request->hasFile('files')) {
            return VnMedia::upload($this->uid);
        }
        $type = getParam('type', '');
        if ($type == 'delete') {
            return VnMedia::removeMedia();
        }
        return false;
    }
}
