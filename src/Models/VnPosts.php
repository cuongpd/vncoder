<?php

namespace VnCoder\Models;

class VnPosts extends VnModel
{
    protected $table = '__posts';
    protected $fillable = ['id', 'parent_id', 'type', 'title', 'slug', 'description', 'photo', 'content' , 'tags'];
    protected $searchFields = ['title' , 'description' ];

    public function parent()
    {
        return $this->hasOne(VnPosts::class, 'id', 'parent_id')->where('type', 'category')->where('status', '>', 0);
    }

    public function child()
    {
        return $this->hasMany(VnPosts::class, 'parent_id', 'id')->where('type', 'category')->where('status', '>', 0);
    }

    public static function getPost($limit = 20)
    {
        $orderBy = getParam('order', 'id');
        $sortBy = getParam('sort', 'desc');

        if (!in_array($orderBy, with(new static())->fillable, true)) {
            $orderBy = 'id';
        }
        $sortBy = $sortBy === 'asc' ? 'asc' : 'desc';
        $query = self::with('parent')->where('type', 'post')->where('status', '>', 0);
        $serchQuery = getParam('_query', '');
        if ($serchQuery) {
            $query->search($serchQuery, ['title', 'description']);
        }
        return $query->orderBy($orderBy, $sortBy)->paginate($limit);
    }

    public static function getPages($limit = 20)
    {
        $orderBy = getParam('order', 'id');
        $sortBy = getParam('sort', 'desc');

        if (!in_array($orderBy, with(new static())->fillable, true)) {
            $orderBy = 'id';
        }
        $sortBy = $sortBy === 'asc' ? 'asc' : 'desc';
        $query = self::where('type', 'page')->where('status', '>', 0);
        $serchQuery = getParam('_query', '');
        if ($serchQuery) {
            $query->search($serchQuery, ['title', 'description']);
        }
        return $query->orderBy($orderBy, $sortBy)->paginate($limit);
    }

    public static function getCategory($parent_id = 0)
    {
        return self::with('child')->where('type', 'category')->where('parent_id', $parent_id)->where('status', '>', 0)->get();
    }

    public static function getPostInfo($id = 0, $type = 'post')
    {
        $postData = self::where('id', $id)->first();
        if ($postData) {
            if ($postData->type !== $type) {
                return false;
            }
        } else {
            $postData = newObject();
            foreach (with(new static())->fillable as $item) {
                $postData->$item = '';
            }
            $postData->type = $type;
        }
        return $postData;
    }

    public static function getParentCategory($parent_id = 0)
    {
        return self::select('id', 'title')->where('type', 'category')->where('parent_id', $parent_id)->where('status', '>', 0)->get();
    }

    public static function getCategoryTree()
    {
        $data = self::getParentCategory(0);
        foreach ($data as $item) {
            $item->child = self::getParentCategory($item->id);
        }
        return $data;
    }

    public static function submitData($data)
    {
        $id = $data['id'] ? (int) $data['id'] : 0;
        $type = $data['type'] ?? 'post';
        $title = $data['title'] ?? '';
        if (!$title) {
            return false;
        }
        $update =[
            'parent_id' => $data['parent_id'] ? (int) $data['parent_id'] : 0,
            'type' => $type,
            'title' => $title,
            'description' => $data['description'] ?? '',
            'photo' => $data['photo'] ?? '',
            'content' => $data['content'] ?? '',
            'tags' => $data['tags'] ?? '',
        ];

        $typeName = self::getTypeName($type);
        if ($id > 0) {
            $update['updated'] = TIME_NOW;
            self::where('id', $id)->update($update);
            flash_message('Đã cập nhật ' . $typeName . ' : ' . $update['title']);
        } else {
            $update['slug'] = self::getSlugUnique($type, $title);
            $update['created'] = TIME_NOW;
            flash_message('Đã thêm ' . $typeName . ' : ' . $update['title']);
            $id = self::insertGetId($update);
        }
        return $id;
    }

    public static function getSlugUnique($type, $title)
    {
        $slug = $slug_default = safe_text($title);
        $counter = 1;
        while ($checkSlug = self::checkSlug($type, $slug)) {
            $slug = $slug_default . '-'. $counter;
            $counter++;
        }
        return $slug;
    }

    public static function getPageContent($slug = '')
    {
        $info = self::where('type', 'page')->where('slug', $slug)->first();
        if ($info) {
            return $info->content;
        }
        return '';
    }

    public static function checkSlug($type, $slug)
    {
        return self::where('type', $type)->where('slug', $slug)->first();
    }

    public static function getTypeName($type = '')
    {
        switch ($type) {
            case 'category':
                return 'Danh mục';
            case 'page':
                return 'Trang';

            default:
                return 'Bài viết';
        }
    }
}
