<?php

namespace app\backend\controller;

use app\backend\model\Admin;
use app\backend\model\Member;
use think\Controller;
use think\Request;

class IndexController extends Controller
{
    public function adminList(){
        $admins=Admin::where("id",">",1)->select();

        return json($admins);
    }

    public function detail($id){
        $members=Member::where("admin_id",$id)->select();

        return json($members);
    }
}
