<?php

namespace app\backend\controller;

use app\backend\model\Admin;
use think\Controller;
use think\Db;
use think\Loader;
use think\Request;

class AdminController extends Controller
{
    /*
     * 顾问列表
     */
    public function index(){
        $admins=Admin::where("id",">",1)->select();

        return json($admins);
    }
    /*
     * 添加顾问
     */
    public function add(Request $request){
        if ($request->isPost()){
            $data=$request->post();
            //验证
            $validate = Loader::validate('Admin');
            if (!$validate->scene('add')->check($data)) {
                return get_json(0, $validate->getError());
            }
            $data['username']=$data['tel'];
            if (Admin::create($data)) {
                return get_json(1,"添加成功");
            }
            return get_json(0,"添加失败");
        }
    }
    /*
     * 修改密码
     */
    public function edit(Request $request,$id){
        $admin=Admin::find($id);
        if ($request->isPost()){
            $data=$request->post();
            if ($data['password']!==$data['re_password']){
                return get_json(0,"两次输入密码不一致");
            }
           // unset($data['re_password']);
            $admin->save($data);
            return get_json(1,"修改密码成功");
        }
    }
    /*
     * 删除顾问
     */
    public function del($id){
        $admin=Admin::find($id);
        $admin->del=0;
        $admin->save();
        return get_json(1,"删除成功");
    }
    /*
     * 通知页面
     */
    public function notice(){
        $notices=Db::name("notice")->select();
        foreach ($notices as $notice){
            $notice['create_time']=date("Y-m-d",$notice['create_time']);
        }
        return get_json(1,"",$notices);
    }
    /*
     * 删除通知
     */
    public function delNotice(){
        $ids=\request()->input("id/a");
        $ids=implode(",",$ids);
        Db::name("notice")->where("id in {$ids}")->delete();
        return get_json(1,"删除成功");
    }
}
