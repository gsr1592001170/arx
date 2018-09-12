<?php

namespace app\backend\controller;

use app\backend\model\Visitor;
use think\Controller;
use think\Loader;
use think\Request;
use think\Session;

class VisitorController extends BaseController
{
    /*
     * 访客列表
     */
    public function index(){
        $adminId=Session::get("admin")['id'];
        $keyword=\request()->get("keyword");
        $visits=Visitor::whereLike("tel","%{$keyword}%")->paginate(3);



        return view("visitor",compact("visits","adminId"));
    }
    /*
     * 添加访客
     */
    public function add(Request $request){
        if ($request->isPost()){
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
        return view("addVisitor");
    }
    /*
     * 删除访客
     */
    public function del($id){

            $visit=Visitor::find($id);
            $visit->delete();
            return $this->redirect("visitor/index");

    }
}
