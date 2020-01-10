<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Wxber extends Model
{
    protected $table = 'wxber';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $guarded = [];//黑名单
}
