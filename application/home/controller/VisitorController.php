<?php

namespace app\home\controller;

use app\home\model\Visitor;
use think\Controller;
use think\Loader;
use think\Request;

class VisitorController extends Controller
{
    /*
     * 顾客登记页面
     */
    public function reg(Request $request){
        if ($request->isPost()){
            $data=$request->post();
            $validate = Loader::validate('Visitor');

            if(!$validate->check($data)){
                return get_json(0,$validate->getError());
            }
            $data['visit_time']=time();

            if (Visitor::create($data)) {
                return get_json(1,"登记成功");
            }

            return get_json(0,"登记失败");
        }
        return view("visitorRegister");
    }
}
