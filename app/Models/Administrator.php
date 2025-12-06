<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Administrator extends Authenticatable
{
    use SoftDeletes;

    protected $table = 'administers';

    // 主キー
    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'name',
        'login_id',
        'password',
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
}