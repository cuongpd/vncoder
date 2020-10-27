<?php

namespace VnCoder\Models;

use Illuminate\Database\Eloquent\Model;

class VnUserSocialite extends Model
{
    public const CREATED_AT = 'created';
    public const UPDATED_AT = 'updated';
    protected $dateFormat = 'U';

    protected $table = '__user_socialite';
    protected $fillable = ['user_id', 'provider', 'auth_id', 'nickname', 'token', 'status'];
}
