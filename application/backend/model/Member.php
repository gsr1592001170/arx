<?php

namespace app\backend\model;

use think\Db;
use think\Model;

class Member extends Model
{
    //
    public function getStatusAttr($value)
    {
        $data=["取消","目标客户","意向客户","预签客户","签约客户"];

        return $data[$value];
    }
    public function getYuchanqiAttr($value)
    {
        return date("Y-m-d",$value);
    }

    public function getVisitTimeAttr($value)
    {
        return date("Y-m-d",$value);
    }

    public function getTimeAttr($value)
    {
        return date("Y-m-d",$value);
    }

    public function getAdminIdAttr($value)
    {
        return Db::name("admin")->where("id",$value)->value("name");
    }
    public function getPrepayTimeAttr($value)
    {
        return date("Y-m-d",$value);
    }
}
