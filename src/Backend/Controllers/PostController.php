<?php

namespace VnCoder\Backend\Controllers;

use VnCoder\Models\VnPostCategory;
use Illuminate\Validation\ValidationException;
use VnCoder\Models\VnPost;
use VnCoder\Models\VnPosts;

class PostController extends BackendController
{
    public function Index_Action()
    {
        $this->metaData->title = 'Danh sách bài viết';
        $this->setData['linkEdit'] = backend('post/edit');
        $this->setData['linkDelete'] = backend('post/delete');
        $this->setData['postData'] = VnPosts::getPost(10);
        return $this->views('post.list');
    }

    public function Edit_Action()
    {
        $postData = VnPosts::getPostInfo($this->id, 'post');
        if (!$postData) {
            return $this->redirectUrl();
        }
        $this->metaData->title = $postData->title ? 'Chỉnh sửa bài viết : ' . $postData->title : 'Thêm bài viết mới';
        $this->setData['category'] = VnPosts::getCategoryTree();
        $this->setData['postData'] = $postData;
        return $this->views('post.edit');
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

    public function Category_Action()
    {
        $this->metaData->title = 'Danh mục bài viết';
        $this->setData['linkEdit'] = backend('post/category-edit');
        $this->setData['linkDelete'] = backend('post/category-delete');
        $this->setData['categoryData'] = VnPosts::getCategory();
        return $this->views('post.category');
    }

    public function Category_Edit_Action()
    {
        $postData = VnPosts::getPostInfo($this->id, 'category');
        if (!$postData) {
            return $this->redirectUrl('category');
        }
        $this->metaData->title = $postData->title ? 'Chỉnh sửa danh mục : ' . $postData->title : 'Thêm danh mục mới';
        $this->setData['category'] = VnPosts::getParentCategory();
        $this->setData['postData'] = $postData;
        return $this->views('post.category-edit');
    }

    public function Category_Delete_Action()
    {
        VnPosts::hiddenId($this->id);
        return $this->redirectUrl('category');
    }

    public function Category_Edit_Action_Submit()
    {
        VnPosts::submitData($this->request->all());
        return $this->redirectUrl('category');
    }
}
