<?php

namespace app\backend\controller;

use app\backend\model\Member;
use think\Controller;
use think\Db;
use think\Request;
use think\Session;

class MemberController extends BaseController
{
    /*
     * 目标客户
     */
    public function target()
    {
        $keyword = \request()->get("keyword") ?? "";
        $query = Member::where("status", 1)->whereLike("tel", "%{$keyword}%");
        if ($this->adminId > 1) {
            $query = $query->where("admin_id", $this->adminId);
        }
        $members = $query->paginate(3);
        if ($this->adminId > 1) {
            return view("adviserCustomer", compact("members"));
        }
        return view("customer", compact("members"));

    }

    /*
     * 编辑目标客户
     */
    public function editTarget(Request $request, $id)
    {
        $member = Member::find($id);
        if ($request->isPost()) {
            $data = $request->post();
            $data['demand'] = implode(",", $data['demand']);
            // halt($data);
            $da['status'] = 2;
            $data['member_id'] = $member->save($da);
            if ($data['member_id']) {
                if (Db::name("content")->insert($data)) {
                    return $this->redirect("member/target");
                }
            }
        }

        return view("adviserIntentEdit", compact("member"));
    }

    /*
     * 意向客户
     */
    public function intention()
    {
        $keyword = \request()->get('keyword') ?? "";
        $query = Member::where("status", 2)->whereLike("tel", "%{$keyword}%");
        if ($this->adminId > 1) {
            $query = $query->where("admin_id", $this->adminId);
        }
        $members = $query->paginate(3);
        if ($this->adminId > 1) {
            return view("adviserIntentCustomer", compact("members"));
        }

        return view("intentCustomer", compact("members"));
    }

    /*
     * 预交诚意金
     */
    public function editIntention(Request $request, $id)
    {
        if ($request->isPost()) {
            $data = $request->post();
            $data['id'] = $id;
            $data['prepay_time'] = strtotime($data['prepay_time']);
            $data['status'] = 3;
            if (Member::update($data)) {
                return $this->redirect("member/intention");
            }
        }
        //显示视图
        return view("adviserPrepay");
    }

    /*
     * 删除意向客户
     */
    public function delIntention($id)
    {
        $member = Member::find($id);
        $member->status = 0;
        $member->save();
        return $this->redirect("member/intention");
    }

    /*
     * 预签约客户
     */
    public function pre()
    {
        $keyword = \request()->get("keyword") ?? "";

        $query = Member::where("status", 3)->whereLike("tel", "%{$keyword}%");
        if ($this->adminId > 1) {
            $query = $query->where("admin_id", $this->adminId);
        }
        $members = $query->paginate(3);
        if ($this->adminId > 1) {
            return view("adviserPreSigning", compact("members"));
        }
        return view("preSigning", compact("members"));
    }

    /*
     * 签约
     */
    public function editPre(Request $request, $id)
    {
        $member = Member::find($id);
        if ($request->isPost()) {
            $data = $request->post();
            $data['time'] = time();
            $data['id'] = $id;
            $data['status'] = 4;
            $data['admin_id'] = $this->adminId;
            if (Member::update($data)) {
                $row = get_row($member['username'] . "签约成功");
                Db::name("notice")->insert($row);
                $admin=Db::name("admin")->where("id",$this->adminId)->find();
                $admin['signer']=$admin['signer']+1;
                $admin['money']=$admin['money']+$data['money'];
                Db::name('admin')->update($admin);
            }

            return $this->redirect("member/pre");
        }
        //显示视图
        return view("adviserPreSigningSign",compact("member"));
    }

    /*
     * 删除预签约客户
     */
    public function delPre($id)
    {
        $member = Member::find($id);
        $member->status=0;
        $member->save();
        return $this->redirect("member/pre");
    }

    /*
     * 签约客户
     */
    public function contract()
    {
        $keyword = \request()->get("keyword") ?? "";
        $query = Member::where("status", 4)->whereLike("tel", "%{$keyword}%");
        if ($this->adminId >1){
            $query=$query->where("admin_id",$this->adminId);
        }
        $members=$query->paginate(3);
        if ($this->adminId >1) {
            return view("adviserSigningCustomer",compact("members"));
        }
            return view("signingCustomer", compact("members"));
    }

    /*
     * 签约客户备注
     */
    public function detail($id)
    {
        $content = Db::name("content")->where("member_id", $id)->find();
        $content['demand'] = explode(",", $content['demand']);
        $data = ["其他", "环境", "地理位置", "产后恢复", "宝宝护理", "营养月子餐"];
        return view("siginingRemarks", compact("content", "data"));
    }

    /*
     * 删除签约客户
     */
    public function delContract($id)
    {
        $member = Member::find($id);
        $member->status=0;
        $member->save();
        return $this->redirect("member/contract");
    }
}
