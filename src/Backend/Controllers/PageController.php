<?php

namespace VnCoder\Backend\Controllers;

use VnCoder\Models\VnPosts;

class PageController extends BackendController
{
    public function Index_Action()
    {
        $this->metaData->title = 'Danh sách trang tĩnh';
        $this->setData['linkEdit'] = backend('page/edit');
        $this->setData['linkDelete'] = backend('page/delete');
        $this->setData['postData'] = VnPosts::getPages(10);

        $this->linkJS('core/js/clipboard.min.js');
        return $this->views('page.list');
    }

    public function Edit_Action()
    {
        $postData = VnPosts::getPostInfo($this->id, 'page');
        if (!$postData) {
            return $this->redirectUrl();
        }
        $this->metaData->title = $postData->title ? 'Chỉnh sửa trang : ' . $postData->title : 'Thêm trang mới';
        $this->setData['postData'] = $postData;
        return $this->views('page.edit');
    }

    public function Delete_Action()
    {
        VnPosts::hiddenId($this->id);
        return $this->redirectUrl();
    }

    public function Edit_Action_Submit()
    {
        VnPosts::submitData($this->request->all());
        return $this->redirectUrl();
    }
}
