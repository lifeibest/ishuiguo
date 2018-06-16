<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Systemconfig extends Model
{
    protected $table = 'systemconfig';

    /**
     * 获得与用户关联的电话记录。
     */
    public function systemconfigType()
    {
        return $this->hasOne(SystemconfigType::class, 'id', 'systemconfig_type_id');
    }
}
