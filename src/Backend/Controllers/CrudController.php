<?php

namespace VnCoder\Backend\Controllers;

class CrudController extends BackendController
{
    protected $model;
    protected $limit = 10;
    protected $id = 0;

    public function __construct()
    {
        parent::__construct();
        if (!$this->model || !$this->model::getModelInfo()) {
            die('Cannot get model. Please define model in controller.<br><b>protected $model = ModelName::class;</b>');
        }
    }


    public function Index_Action()
    {
        $orderBy = getParam('orderBy');
        $sortBy = getParam('sortBy', 'desc');

        $this->setData['__orderBy'] = $orderBy;
        $this->setData['__sortBy'] = $sortBy === 'asc' ? 'desc' : 'asc';
        $this->setData['pageUrl'] = backend($this->controller);

        $this->setData['keys'] = $this->model::getQueryField();
        $this->setData['data'] = $this->model::getData($orderBy, $sortBy, $this->limit);

        $this->setData['linkCreate'] = $this->linkController . '/create';
        $this->setData['linkEdit'] = $this->linkController . '/edit';
        $this->setData['linkDelete'] = $this->linkController . '/delete';
        $this->setData['linkExport'] = $this->linkController . '/export';

        return $this->views('crud.list');
    }

    public function Add_Action()
    {
        $this->setData['form'] = $this->model::getForm();
        return $this->views('crud.edit');
    }

    public function Edit_Action()
    {
        $formData = $this->model::getFormData($this->id);
        $formHelper = new FormHelper();

        $this->setData['html_form'] = $formHelper->setData($formData)->html();
        return $this->views('crud.edit');
    }

    public function Delete_Action()
    {
        $this->model::hiddenId($this->id);
        return redirect($this->linkController);
    }
}
