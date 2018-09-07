<?php

namespace app\home\controller;

use app\home\model\User;
use think\Controller;
use think\Db;
use think\Loader;
use think\Request;

class UserController extends Controller
{
    /**
     * 参观登记页面
     */
    public function reg(Request $request){
       if ($request->isPost()){
           $data=$request->post();
           $data['yuchanqi']=strtotime($data['yuchanqi']);
           $data['status']=1;
           //验证
           $validate = Loader::validate('User');
           if(!$validate->scene('reg')->check($data)){
               return get_json(0,$validate->getError());
           }
           $user=User::where("tel",$data['tel'])->find();
           if ($user != null && $user->status==0){
               if ($user->save($data)){
                   return get_json(1,"登记成功");
               }else{
                   return get_json(0,"登记失败");
               }
           }
           if ($user !=null && $user->status==1){
               return get_json(0,"非法操作：重复登记");
           }
           //入库
           $data['visit_time']=time();
           if (User::create($data)) {
               return get_json(1,"登记成功");
           }
           return get_json(0,"登记失败");
       }
       return view("visitRegister");
    }

    /**
     *预约登记页面
     */
    public function makeReg(Request $request){
        if ($request->isPost()){
            $data=$request->post();
            $data['visit_time']=strtotime($data['visit_time']);
            $data['status']=0;
            //halt($data);
            //验证
            $validate = Loader::validate('User');
            if(!$validate->scene('makereg')->check($data)){
                return get_json(0,$validate->getError());
            }
            if (User::create($data)) {
                $row=get_row($data['username']."线上预约参观成功");
                if (Db::name("notice")->insert($row)) {
                    return get_json(1,"预约成功");
                }
            }
            return get_json(0,"预约失败");
        }
        return view("bespeakRegister");
    }
}
