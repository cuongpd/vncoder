<?php

namespace VnCoder\Backend\Controllers;

use VnCoder\Controllers\VnController;
use Illuminate\Validation\ValidationException;
use VnCoder\Backend\Models\VnAdminMenu;

class BackendController extends VnController
{
    protected $id = 0;
    protected $_query;
    protected $version = TIME_NOW;
    protected $controller ;
    protected $action;
    protected $linkController;
    protected $__breadcrumb = [];
    protected $isBackend = true;
    protected $viewNamespace = 'backend';
    protected $request = null;
    protected $isFormEditor = false;
    protected $showSearchForm = false;
    protected $debugbar = false;
    protected $title = '';
    protected $is_root = false;

    protected function siteInit(): void
    {
        // Load Style
        $this->linkCSS('core/css/codebase.min.css', false);
        $this->linkJS('core/js/jquery.min.js', true);
        $this->linkJS('core/js/core.min.js');
        $this->linkJS('core/js/app.min.js');
        $this->linkJS('core/js/filemanager.js');

        // Fix Debugbar
        $debugbar = cookie('_debugbar');
        if ($debugbar === 'on') {
            $this->debugbar = true;
        }
        $this->setData['__debugbar'] = $this->debugbar ? 'ON' : 'OFF';

        $this->request = app('request');

        $this->_query = getParam('_query', '');
        $this->id = getParamInt('id', 0);
        $this->setData['__query'] = $this->_query;

        $segments = request()->segments();
        $this->controller = $segments[1] ?? '';
        $this->action = $segments[2] ?? '';

        if (strpos($this->action, 'add') !== false || strpos($this->action, 'create') !== false || strpos($this->action, 'edit') !== false) {
            $this->isFormEditor = true;
        }

        $this->linkController = backend($this->controller);

        $breadcrumb = [];
        $breadcrumb[] = [
            'name' => getKeyName($this->controller),
            'link' => $this->linkController
        ];

        $this->__breadcrumb = $breadcrumb;
        $this->setData['__controller'] = $this->controller;
        $this->setData['__action'] = $this->action;
    }

    protected function redirectUrl($action = '')
    {
        $uri = $action ? $this->controller . '.' . $action : $this->controller;
        return redirect(backend($uri));
    }

    protected function views($bladeName = '')
    {
        $this->setData['__metaData'] = $this->metaData;
        $this->__breadcrumb[] = ['name' => $this->metaData->title , 'url' => '#'];
        $this->setData['__breadcrumb'] = $this->__breadcrumb;
        if ($this->title) {
            $this->metaData->title = $this->title;
        }
        if ($this->isFormEditor) {
            $this->initFormEditor();
        }
        // Auto load menu
        $this->setData['__backendMenu'] = VnAdminMenu::loader($this->uid);
        $this->setData['__showSearchForm'] = $this->showSearchForm;
        if ($this->viewNamespace == 'backend') {
            $this->setData['__bladeRender'] = 'backend::pages.' . $bladeName;
        } else {
            $this->setData['__bladeRender'] = 'admin::' . $bladeName;
        }
        return parent::views($bladeName);
    }

    protected function initDataTable(){
        $this->linkCSS('core/plugins/datatables/dataTables.bootstrap4.css');
        $this->linkJS('core/plugins/datatables/jquery.dataTables.min.js');
        $this->linkJS('core/plugins/datatables/dataTables.bootstrap4.min.js');
    }

    protected function initFormEditor(){
        // Summernote
        $this->linkCSS('core/plugins/summernote/summernote-bs4.css');
        $this->linkJS('core/plugins/summernote/summernote-bs4.min.js');
        $this->linkJS('core/plugins/summernote/media-upload.js');
        // Tag Input
        $this->linkCSS('core/plugins/jquery-tags-input/jquery.tagsinput.min.css');
        $this->linkJS('core/plugins/jquery-tags-input/jquery.tagsinput.min.js');
        // Select 2
        $this->linkCSS('core/plugins/select2/css/select2.min.css');
        $this->linkJS('core/plugins/select2/js/select2.min.js');
        // Cleave Format Input
        $this->linkJS('core/js/cleave.min.js');
        $this->footer("<script>jQuery(function(){ Codebase.helpers(['select2','tags-inputs']); });</script>");
    }

    protected function validateForm($rules = [])
    {
        try {
            $this->validate($this->request, $rules, $this->validateMessage());
        } catch (ValidationException $e) {
            flash_error($e->errors());
            return redirect(getParam('_request_url'));
        }
        return true;
    }

    protected function validateMessage()
    {
        return [
            'email' => ':attribute bạn nhập không phải là Email hợp lệ.',
            'exists' => ':attribute bạn nhập chưa có trên hệ thống, vui lòng kiểm tra lại.',
            'required' => 'Trường :attribute không được để trống.',
            'unique' => ':attribute bạn nhập đã tồn tại trong hệ thống.',
            'confirmed' => ':attribute bạn nhập cần khớp nhau!',
            'between' => ':attribute cần trong khoản từ :min đến :max kí tự!',
            'min' => ':attribute cần nhiều hơn hoặc bằng :min kí tự!',
            'max' => ':attribute cần nhỏ hơn hoặc bằng :min kí tự!',
        ];
    }
}