<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $table = 'news';
    protected $primaryKey = 'new_id';
    public $timestamps = false;
    protected $guarded = [];//黑名单
}
