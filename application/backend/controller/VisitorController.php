<?php

namespace app\backend\controller;

use app\home\model\Visitor;
use think\Controller;
use think\Loader;
use think\Request;
use think\Session;

class VisitorController extends Controller
{
    /*
     * 访客列表
     */
    public function index(){
        $vists=Visitor::all();

        return get_json(1,"",$vists);
    }
    /*
     * 添加访客
     */
    public function add(Request $request){
        $data=$request->post();
        $validate=Loader::validate("Visitor");
        if (!$validate->check($data)) {
            return get_json(0, $validate->getError());
        }
        $data['visit_time']=time();
        if (Visitor::create($data)) {
            return get_json(1,"添加成功");
        }
        return get_json(0,"添加失败");
    }
    /*
     * 删除访客
     */
    public function del($id){
        if (Session::get("admin")['id']===1){
            $visit=Visitor::find($id);
            $visit->delete();
            return get_json(1,"删除成功");
        }else{
            return get_json(0,"删除失败:你没有权限！");
        }
    }
}
