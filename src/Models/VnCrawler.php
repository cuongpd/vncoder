<?php

namespace VnCoder\Models;

use Illuminate\Database\Eloquent\Model;

class VnCrawler extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $table = '__crawler';
    protected $fillable = ['id','source','category','title','description','photo','content','data','status'];

    public static function saveData($url, $data)
    {
        return self::updateOrCreate(['source' => $url], $data);
    }
}
