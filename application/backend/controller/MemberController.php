<?php

namespace app\backend\controller;

use app\backend\model\Member;
use think\Controller;
use think\Db;
use think\Request;
use think\Session;

class MemberController extends Controller
{
    public $adminId;
    public function _initialize()
    {
        $this->adminId = Session::get("admin")['id'];
        parent::_initialize();
    }
    /*
     * 目标客户
     */
    public function target(){

       if ($this->adminId > 1){
           $members =  Member::where("status",1)->where("admin_id",$this->adminId)->select();
       }else{
           $members = Member::where("status",1)->select();
       }

       return get_json(1,"",$members);

    }
    /*
     * 编辑目标客户
     */
    public function editTarget(Request $request,$id){
        $member=Member::find($id);
        if ($request->isPost()){
            $data=$request->post();
            $data['member_id']=Member::update($data);
            if ($data['member_id']) {
                if (Db::name("content")->insert($data)) {
                    return get_json(1,"该客户已成为意向客户");
                }
            }
            return get_json(0,"操作失败");
        }

        return get_json(1,"",$member);
    }
    /*
     * 意向客户
     */
    public function intention(){
        if ($this->adminId > 1){
            $members = Member::where("status",2)->where("admin_id",$this->adminId)->select();
        }else{
            $members = Member::where("status",2)->select();
        }

        return $members;
    }
    /*
     * 预交诚意金
     */
    public function editIntention(Request $request,$id){
        if ($request->isPost()){
            $data=$request->post();

            if (Member::update($data)) {
                return get_json(1,"缴费成功");
            }
        }
        //显示视图
    }
    /*
     * 删除目标客户
     */
    public function delIntention($id){
        $member=Member::find($id);
        $member->delete();
        return get_json(1,"删除成功");
    }
    /*
     * 预签约客户
     */
    public function pre(){
        if ($this->adminId > 1){
            $members = Member::where("status",3)->where("admin_id",$this->adminId)->select();
        }else{
            $members = Member::where("status",3)->select();
        }

        return get_json(1,"",$members);
    }
    /*
     * 签约
     */
    public function editPre(Request $request,$id){
        $member=Member::find($id);
        if ($request->isPost()){
           $data = $request->post();

            if ($member->save($data)) {
                $row=get_row($member['username']."签约成功");
                Db::name("notice")->insert($row);
            }

           return get_json(1,"签约成功");
        }
        //显示视图
    }
    /*
     * 删除预签约客户
     */
    public function delPre($id){
        $member=Member::find($id);
        $member->delete();
        return get_json(1,"删除成功");
    }
    /*
     * 签约客户
     */
    public function contract(){
        if ($this->adminId > 1){
            $members = Member::where("status",4)->where("admin_id",$this->adminId)->select();
        }else{
            $members = Member::where("status",4)->select();
        }
        return get_json(1,"",$members);
    }
    /*
     * 签约客户备注
     */
    public function detail($id){
        $content=Db::name("content")->where("member_id",$id)->select();
        return $content;
    }
    /*
     * 删除签约客户
     */
    public function delContract($id){
        $member=Member::find($id);
        $member->delete();
        return get_json(1,"删除成功");
    }
}
