<?php

namespace app\backend\model;

use think\Model;

class User extends Model
{
    public function getVisitTimeAttr($value)
    {
        return date("Y-m-d",$value);
    }
}
