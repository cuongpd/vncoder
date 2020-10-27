<?php

namespace VnCoder\Models;

use Illuminate\Database\Eloquent\Model;

class VnRole extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $table = '__roles';

    protected $fillable = ['id', 'name', 'description', 'permission'];


    public static function getRoles()
    {
        return self::select('id', 'name', 'description', 'permission')->where('status', '>', 0)->get();
    }

    public static function getInfo($uid = 0)
    {
        return self::where('id', $uid)->first();
    }

    public static function getRoleById($uid = 0)
    {
        return range(1, 100);
    }

    public static function addRole($name, $description)
    {
        return self::create(['name' => $name, 'description' => $description]);
    }
    public static function editRole($uid, $data)
    {
        return self::where('id', $uid)->update($data);
    }

    public static function checkRootUser($uid)
    {
        return false;
    }
}
