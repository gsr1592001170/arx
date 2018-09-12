<?php

namespace app\backend\controller;

use app\backend\model\Admin;
use think\Controller;
use think\Loader;
use think\Request;
use think\Session;

class LoginController extends Controller
{
    public function login(Request $request){
        if ($request->isPost()){
            $data=$request->post();
           // halt($data);
            //验证
            $validate = Loader::validate('Admin');
            if (!$validate->scene('login')->check($data)) {
                return get_json(0, $validate->getError());
            }
            $admin=Admin::where("username",$data['username'])->find();

            //halt($admin);
            if ($admin==null){
                return get_json(0,"该账号不存在");
            }
            if ($data['password']==$admin->password){
                Session::set("admin",$admin->toArray());
                return get_json(1,"登录成功");
            }else{
                return get_json(0,"密码输入有误！");
            }
       }
        return view("login");
    }

    public function logout(){
        Session::set("admin","");

        return $this->redirect("login/login");
    }
}
