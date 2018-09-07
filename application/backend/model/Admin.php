<?php

namespace app\backend\model;

use think\Model;

class Admin extends Model
{
    public function getDelAttr($value)
    {
        $data=["离职顾问","在职顾问"];
        return $data[$value];
    }
}
