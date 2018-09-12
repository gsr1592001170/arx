<?php

namespace app\backend\controller;

use app\backend\model\Member;
use app\backend\model\User;
use think\Controller;
use think\Loader;
use think\Request;
use think\Session;

class UserController extends BaseController
{
    /**
     * @param Request $request
     * @return \think\response\Json
     * 添加游客
     */
    public function add(Request $request)
    {

        if ($request->isPost()) {
            $data = $request->post();
            //验证
            $validate = Loader::validate('User');
            if (!$validate->check($data)) {
                return get_json(0,$validate->getError());
            }

            if (isset($data['visit_time'])) {
                $data['visit_time'] = strtotime($data['visit_time']);
                $data['status'] = 0;
            } else {
                $data['visit_time']=time();
                $data['status'] = 1;
            }
            if (User::create($data)) {
                return get_json(1, "添加成功");
            }

            return get_json(0, "添加失败");
        }
        //显示视图
        return view("addUser");
    }
    /*
     * 游客列表
     */
    public function index(){
        $keyword=\request()->get("keyword")??"";
        $users=User::paginate(3);
        foreach ($users as $k=>$user){
            $users[$k]=$user->toArray();
            if ($keyword!=null && $user['visit_time']!=$keyword){
                unset($users[$k]);
            }
        }
        if ($this->adminId>1){
            return view("adviserTourist",compact("users"));
        }
        return view("tourist",compact("users"));
    }
    /*
     * 接待游客
     */
    public function save($id){
        $user=User::find($id);
        if ($user==null){
            return get_json(0,"此客户不存在");
        }
        $data=$user->toArray();
        unset($data['id']);
        $data['admin_id']=2;
        $data['status']=1;
        $data['source']=$data['source']??"其他";
        Member::create($data);
        $user->delete();

        return $this->redirect("user/index");
    }

    /*
     * 删除游客
     */
    public function del($id){

        $user=User::find($id);

        $user->delete();

        return $this->redirect("user/index");
    }
}
