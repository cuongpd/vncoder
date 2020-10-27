<?php

namespace VnCoder\Models;

class VnPostCategory extends VnModel
{
    protected $table = '__post_category';
    protected $fillable = ['parent_id', 'title', 'description', 'photo', 'content'];

    protected $rules = [
        'title' => 'required|min:3',
        'description' => 'max:255',
    ];

    public function child()
    {
        return $this->hasMany(VnPostCategory::class, 'parent_id', 'id')->where('status', '>', 0);
    }

    public function parent()
    {
        return $this->hasOne(VnPostCategory::class, 'id', 'parent_id')->where('status', '>', 0);
    }

    public static function deleteCategory($catId)
    {
        $data = self::where('id', $catId)->with('child')->first();
        if ($data) {
            $ids = $data->child->pluck('id');
            $ids[] = $catId;
            self::whereIn('id', $ids)->update(['status' => -1]);
            flash_message('Bản ghi đã bị xoá!');
        } else {
            flash_message('Không tìm thấy bản ghi!');
        }
    }

    public static function getQuery($parent_id = 0)
    {
        return self::where('status', '>', 0)->where('parent_id', 0)->with('child')->get();
    }

    public static function getCategoryTree($parent_id = 0)
    {
        return self::where('status', '>', 0)->where('parent_id', 0)->with('child')->get();
    }

    public static function getParentCategory()
    {
        return self::where('status', '>', 0)->where('parent_id', 0)->get();
    }
}
