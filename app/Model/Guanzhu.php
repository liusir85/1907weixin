<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Guanzhu extends Model
{
    protected $table = 'guanzhu';
    protected $primaryKey = 'g_id';
    public $timestamps = false;
    protected $guarded = [];//黑名单
}
