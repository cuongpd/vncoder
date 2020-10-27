<?php

namespace VnCoder\Backend\Models;

use VnCoder\Models\VnRole;

class VnAdminMenu
{
    public static function menu()
    {
        $menu = [];
        if (file_exists(ADMIN_PATH . 'menu.php')) {
            $menu = include ADMIN_PATH . 'menu.php';
        }
        $coreMenu = self::coreMenu();
        if (!$menu) {
            return $coreMenu;
        }
        $data = [];
        foreach ($menu as $key => $item) {
            if (isset($coreMenu[$key])) {
                $submenu = $item['submenu'] ?? [];
                $submenuCore = $coreMenu[$key]['submenu'] ?? [];
                $item['submenu'] = array_merge($submenuCore, $submenu);
                $item['rank'] = $coreMenu[$key]['rank'] ?? 10;
                unset($coreMenu[$key]);
            }
            $data[$key] = $item;
        }

        $menuInfo = array_merge($data, $coreMenu);
        return collect($menuInfo)->sortByDesc('rank')->reverse()->toArray();
    }

    public static function loader($uid = 0)
    {
        $menu = [];
        $menuData = self::menu();
        $currentUrl = request()->url();
        $isRootUser = true;
        $roleMenus = [];

        $page_active = 0;
        foreach ($menuData as $key => $items) {
            $parentMenu = $items;
            $parentMenu['active'] = 0;
            if (isset($items['submenu']) && count($items['submenu']) > 0) {
                $subMenu = [];
                foreach ($items['submenu'] as $k => $item) {
                    if ($isRootUser || in_array($k, $roleMenus)) {
                        if (self::compareUrl($currentUrl, $item['url'])) {
                            $parentMenu['active'] = 1;
                            $item['active'] = 1;
                            $page_active = 1;
                        }
                        $subMenu[] = $item;
                    }
                }
                if ($subMenu) {
                    $parentMenu['submenu'] = $subMenu;
                    $menu[] = $parentMenu;
                }
            } else {
                if ($isRootUser || in_array($key, $roleMenus)) {
                    $parentMenu['submenu'] = [];
                    if ($page_active == 0) {
                        if (self::compareUrl($currentUrl, $parentMenu['url'])) {
                            $parentMenu['active'] = 1;
                            $page_active = 1;
                        }
                    }
                    $menu[] = $parentMenu;
                }
            }
        }
        return $menu;
    }

    public static function coreMenu()
    {
        return [
            'posts' => [
                'name' => 'Bài viết', 'heading' => 'Quản trị nội dung', 'url' => '#', 'icon' => 'si si-book-open', 'rank' => 90, 'submenu' => [
                    'all' => ['name' => 'Tất cả Bài viết', 'url' => backend('post')],
                    'create' => ['name' => 'Viết bài mới', 'url' => backend('post.edit')],
                    'category' => ['name' => 'Danh mục', 'url' => backend('post.category')],
                ]
            ],
            'pages' => ['name' => 'Trang', 'url' => backend('page'), 'icon' => 'si si-note', 'rank' => 91, 'submenu' => []],
            'medias' => ['name' => 'Media', 'url' => backend('media'),'rank' => 92, 'icon' => 'si si-folder'],
            'setting' => [
                'name' => 'Quản trị', 'heading' => 'Cấu hình Hệ thống', 'url' => '#', 'icon' => 'si si-settings', 'rank' => 95, 'submenu' => [
                    'default' => ['name' => 'Cấu hình chung', 'url' => backend('setting')],
                    'website' => ['name' => 'Cấu hình Website', 'url' => backend('setting.website')],
                    'content' => ['name' => 'Cấu hình Nội dung', 'url' => backend('setting.content')],
                ]
            ],
            'systems' => [
                'name' => 'Hệ thống', 'url' => '#', 'icon' => 'si si-organization', 'rank' => 98, 'submenu' => [
                    'users' => ['name' => 'Người dùng', 'url' => backend('user')],
                    'roles' => ['name' => 'Phân quyền', 'url' => backend('user.role')],
                    'logs' => ['name' => 'Xem Logs', 'url' => backend('logs')],
                ]
            ],
            'tools' => [
                'name' => 'Công cụ', 'url' => '#', 'icon' => 'si si-fire', 'rank' => 99, 'submenu' => [
                    'shopee' => ['name' => 'Săn Sale', 'url' => backend('tools.shopee')],
                ]
            ]
        ];
    }

    public static function compareUrl($currentUrl, $menuUrl)
    {
        return strpos($currentUrl, $menuUrl) !== false;
    }
}
