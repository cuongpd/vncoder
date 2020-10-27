<?php

namespace VnCoder\Backend\Controllers;

use VnCoder\Models\VnConfig;

class SettingController extends BackendController
{
    public function Index_Action()
    {
        $this->isFormEditor = true;
        $this->metaData->title = 'Cấu hình chung';
        return $this->views('admin.setting');
    }

    public function Index_Action_Submit()
    {
        VnConfig::saveConfig($this->request->all());
        return $this->redirectUrl();
    }

    public function Website_Action()
    {
        $this->isFormEditor = true;
        $this->metaData->title = 'Cấu hình tuỳ biến website';
        $this->setData['formData'] = VnConfig::formConfig();
        return $this->views('admin.setting-form');
    }

    public function Website_Action_Submit()
    {
        VnConfig::saveConfig($this->request->all());
        return $this->redirectUrl('website');
    }

    public function Content_Action()
    {
        $this->isFormEditor = true;
        $this->metaData->title = 'Cấu hình nội dung tuỳ biến';
        $this->setData['formData'] = VnConfig::formContent();
        return $this->views('admin.setting-content');
    }

    public function Content_Action_Submit()
    {
        VnConfig::saveContent($this->request->all());
        return $this->redirectUrl('content');
    }
}
