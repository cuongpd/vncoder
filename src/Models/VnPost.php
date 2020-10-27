<?php

namespace VnCoder\Models;

class VnPost extends VnModel
{
    protected $table = '__post';
    protected $fillable = ['id', 'cat_id', 'title', 'description', 'photo', 'content' , 'tags'];
    protected $searchFields = ['title' , 'description' ];

    protected $rules = [
        'cat_id' => 'required',
        'title' => 'required|min:10',
        'description' => 'min:255',
        'photo' => 'required',
        'content' => 'required',
    ];

    public function category()
    {
        return $this->hasOne(VnPostCategory::class, 'id', 'cat_id')->where('status', '>', 0);
    }
}
