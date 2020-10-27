<?php

namespace VnCoder\Models;

class VnPage extends VnModel
{
    protected $table = '__page';
    protected $fillable = ['slug', 'title', 'description', 'photo', 'content'];

    protected $rules = [
//        'slug' => 'required|unique:vn_page,slug',
        'title' => 'required|min:3',
        'description' => 'max:255',
        'photo' => 'required',
        'content' => 'required',
    ];


    public static function getPage($slug = '')
    {
        $query = self::where('slug', $slug)->first();
        if (!$query) {
            $query = newObject();
            $query->id = 0;
            $query->title = '';
            $query->description = '';
            $query->photo = '';
            $query->content = '';
        }
        return $query;
    }
}
