<?php

namespace app\backend\controller;

use app\backend\model\Admin;
use app\backend\model\Notice;
use think\Controller;
use think\Db;
use think\Loader;
use think\Request;

class AdminController extends BaseController
{
    /*
     * 顾问列表
     */
    public function index()
    {
        $keyword = \request()->get("keyword") ?? "";

        $admins = Admin::where("id", ">", 1)->whereLike("tel", "%{$keyword}%")->paginate(3);

        return view("adviserList", compact("admins"));
    }

    /*
     * 添加顾问
     */
    public function add(Request $request)
    {
        if ($request->isPost()) {
            $data = $request->post();
            //验证
            $validate = Loader::validate('Admin');
            if (!$validate->scene('add')->check($data)) {
                return get_json(0, $validate->getError());
            }
            $data['username'] = $data['tel'];
            if (Admin::create($data)) {
                return get_json(1, "添加成功");
            }
            return get_json(0, "添加失败");
        }
        return view("addAdviser");
    }

    /*
     * 修改密码
     */
    public function edit(Request $request, $id)
    {
        $admin = Admin::find($id);
        if ($request->isPost()) {
            $data = $request->post();
            if ($data['password'] == null || $data['re_password'] == null) {
                return get_json(0, "密码不能为空");
            }
            if ($data['password'] !== $data['re_password']) {
                return get_json("0", "两个输入密码不一致");
            }
            unset($data['re_password']);
            $admin->save($data);
            return get_json(1, "修改密码成功");
        }

        return view("updatePassword");
    }

    /*
     * 删除顾问
     */
    public function del($id)
    {
        $admin = Admin::find($id);
        $admin->del = 0;
        $admin->save();
        return $this->redirect("admin/index", "删除成功");

    }

    /*
     * 通知页面
     */
    public function notice()
    {
        $keyword = \request()->get("keyword") ?? "";

        $notices =Notice::paginate(15);

        foreach ($notices as $k => $notice) {
            if ($keyword != null && $keyword != $notice['create_time']) {
                unset($notices[$k]);
            }
        }

        return view("news",compact("notices"));
    }

    /*
     * 删除通知
     */
    public function delNotice($id)
    {
        Db::name("notice")->where("id",$id)->delete();
        return $this->redirect("admin/notice");
    }
}
