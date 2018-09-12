<?php

namespace app\backend\model;

use think\Model;

class Notice extends Model
{
    public function getCreateTimeAttr($value)
    {
        return date("Y-m-d H:i:s",$value);
    }
}
