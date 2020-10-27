<?php

namespace VnCoder\Backend\Controllers;

use VnCoder\Models\VnUser;
use VnCoder\Backend\Models\VnAdmin;
use VnCoder\Models\VnRole;
use VnCoder\Models\VnPost;
use Illuminate\Validation\ValidationException;
use VnCoder\Backend\Models\VnAdminMenu;

class UserController extends BackendController
{
    public function Index_Action()
    {
        $this->metaData->title = "Danh sách người dùng";
        $this->setData['linkAdd'] = backend('user.add');
        $this->setData['linkEdit'] = backend('user.edit');
        $this->setData['linkLock'] = backend('user.lock');
        $this->setData['linkUnLock'] = backend('user.unlock');

        $this->setData['userData'] = VnAdmin::getUserData(50);
        $this->showSearchForm = true;
        return $this->views('user.user');
    }

    public function Add_Action()
    {
    }

    public function Edit_Action()
    {
    }

    public function Lock_Action()
    {
        VnUser::deactive($this->id);
        return $this->redirectUrl();
    }

    public function Unlock_Action()
    {
        VnUser::active($this->id);
        return $this->redirectUrl();
    }

    // Role Action
    public function Role_Action()
    {
        $this->metaData->title = "Danh sách quyền người dùng";
        $this->setData['roleData'] = VnRole::getRoles();
        $this->setData['linkAdd'] = backend('user.role-add');
        $this->setData['linkEdit'] = backend('user.role-edit');
        $this->setData['linkDelete'] = backend('user.role-delete');
        $this->setData['linkPermission'] = backend('user.role-permission');
        return $this->views('user.role');
    }

    public function Role_Add_Action()
    {
        $this->metaData->title = "Thêm quyền quản trị";
        return $this->views('user.role-create');
    }

    public function Role_Edit_Action()
    {
        $id = getParamInt('id', 0);
        if ($id == 1) {
            flash_message('Quyền Root không được sửa đổi');
            return $this->redirectUrl('role');
        }
        $roleInfo = VnRole::getInfo($this->id);
        if (!$roleInfo) {
            return $this->redirectUrl('role');
        }
        $this->metaData->title = "Chỉnh sửa quyền quản trị: ".$roleInfo->name;
        $this->setData['data'] = $roleInfo;
        return $this->views('user.role-edit');
    }

    public function Role_Add_Action_Submit()
    {
        $name = getParam('name');
        $description = getParam('description');
        VnRole::addRole($name, $description);
        flash_message('Đã cập nhật role: '.$name);
        return $this->redirectUrl('role');
    }

    public function Role_Edit_Action_Submit()
    {
        $name = getParam('name');
        $description = getParam('description');
        VnRole::editRole($this->id, array('name' => $name , 'description' => $description));
        flash_message('Đã cập nhật role: '.$name);
        return $this->redirectUrl('role');
    }

    public function Role_Permission_Action()
    {
        $id = getParamInt('id', 0);
        if ($id == 1) {
            flash_message('Quyền Root có toàn quyền quản trị!');
            return $this->redirectUrl('role');
        }
        $roleInfo = VnRole::getInfo($id);
        if (!$roleInfo) {
            flash_message('Không tìm thấy quyền quản trị với id : '.$id);
            return $this->redirectUrl('role');
        }

        $this->metaData->title = "Tùy chỉnh quyền quản trị: ".$roleInfo->name;
        $this->setData['roleInfo'] = $roleInfo;
        $this->setData['roleMenu'] = VnAdminMenu::menu();
        return $this->views('user.role-permission');
    }

    public function Profile_Action()
    {
        return $this->views('user.profile');
    }
}
