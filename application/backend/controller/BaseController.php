<?php

namespace app\backend\controller;

use think\Controller;
use think\Request;
use think\Session;

class BaseController extends Controller
{
    public $adminId;
    public function _initialize()
    {
        $admin = Session::get("admin");
        if (empty($admin)){
            return $this->redirect("login/login");
        }
        $this->adminId=$admin['id'];
        parent::_initialize(); // TODO: Change the autogenerated stub
    }
}
