<?php

namespace app\backend\model;

use think\Model;

class Member extends Model
{
    //
    public function getStatusAttr($value)
    {
        $data=["取消","目标客户","意向客户","预签客户","签约客户"];

        return $data[$value];
    }
}
