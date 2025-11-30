<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Member extends Authenticatable
{
    use SoftDeletes;

    protected $table = 'members';

    // 主キー
    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'name_sei',
        'name_mei',
        'nickname',
        'gender',
        'email',
        'password',
        'auth_code',
    ];

    // 非表示にするカラム
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // 論理削除用
    protected $dates = [
        'deleted_at',
    ];

    /**
     * フルネーム取得（姓 + 名）
     */
    public function getFullNameAttribute()
    {
        return $this->name_sei . ' ' . $this->name_mei;
    }
}