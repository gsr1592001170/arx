<?php

namespace app\backend\controller;

use app\backend\model\Admin;
use app\backend\model\Member;
use think\Controller;
use think\Db;
use think\Request;
use think\Session;

class IndexController extends BaseController
{

    public function index(Request $request)
    {
        $admin=Session::get("admin");
        if ($admin['id']>1){
            return view("adviser",compact("admin"));
        }
        return view("manage",compact("admin"));
    }
    public function data(){
        $data = [
            "yj" => [
                "count" => Db::name("member")->where("status", 4)->count(),
                "moneys" => Db::name("member")->where("status", 4)->sum("money"),
            ],
            "thirty" => $this->thirty(),
            "count" =>$this->count(),
            "seven"=>$this->days(),
            "one"=>$this->day(),
        ];
        return view("data",compact("data"));
    }

    public function adviserpersonaldata(){
        $data = [
            "yj" => [
                "count" => Db::name("member")->where("status", 4)->where("admin_id",$this->adminId)->count(),
                "moneys" => Db::name("member")->where("status", 4)->where("admin_id",$this->adminId)->sum("money"),
            ],
            "thirty" => $this->thirty(),
            "count" =>$this->count(),
            "seven"=>$this->days(),
            "one"=>$this->day(),
        ];


        return view("adviserPersonalData",compact("data"));
    }

    /*
     * 业绩查询
     */
    public function adminList()
    {

        $admins = Admin::where("id", ">", 1)->select();

       foreach ($admins as $k=>$admin){
           $admins[$k]=$admin->toArray();
       }
        return view("performance",compact("admins"));
    }

    /*
     * 业绩详情
     */
    public function detail(Request $request,$id)
    {

        $members = Member::where("admin_id", $id)->select();

        return view("dataDatail",compact("members"));
    }

    /*
     * 数据统计
     */
    public function count()
    {

        $ly = Db::name("member")->column("source");
        $query = Db::name("member");
        if ($this->adminId > 1){
            $query=$query->where("admin_id",$this->adminId);
        }
        $zl=$query->column("status");
        $xq = Db::name("content")->column("demand");
        $xq = implode(",", $xq);
        $xq = explode(",", $xq);
        $data = [
            "ly" => array_count_values($ly),
            "zl" => array_count_values($zl),
            "xq" => array_count_values($xq),
        ];
        foreach ($data['ly'] as $k => $vly) {
            $data['ly'][$k] = round($vly / array_sum($data['ly']) * 100);
        }
        foreach ($data['xq'] as $k => $vly) {
            $data['xq'][$k] = round($vly / array_sum($data['xq']) * 100);
        }
        $data['zl']['0'] = Db::name("user")->where("status", 0)->count();


        return $data;
    }

    /*
     * 最近30天数据
     */
    public function thirty()
    {
        $time = time();
        $first = strtotime("-28day");//第一周时间戳
        $second = strtotime("-21day");//第二周时间戳
        $third = strtotime("-14day");//第三周时间戳
        $fourth = strtotime("-7day");//第四周时间戳
        $query = Db::name("member")->where("status", 4);
        if ($this->adminId>1){
            $query=$query->where("admin_id",$this->adminId);
        }

        $rows=$query->select();
        $data = [
            "first" => 0,
            "second" => 0,
            "third" => 0,
            "fourth" => 0,
            "firstc" => 0,
            "secondc" => 0,
            "thirdc" => 0,
            "fourthc" => 0,
        ];
        foreach ($rows as $k => $row) {
            switch (true) {
                case $row['time'] > $first && $row['time'] < $second :
                    $data['first'] = $data['first'] + $row['money'];
                    $data['firstc']++;
                    break;
                case $row['time'] > $second && $row['time'] < $third;
                    $data['second'] = $data['second'] + $row['money'];
                    $data['secondc']++;
                    break;
                case $row['time'] > $third && $row['time'] < $fourth;
                    $data['third'] = $data['third'] + $row['money'];
                    $data['thirdc']++;
                    break;
                case $row['time'] > $fourth && $row['time'] < $time;
                    $data['fourth'] = $data['fourth'] + $row['money'];
                    $data['fourthc']++;
                    break;
            }
        }

        return $data;

    }

    /*
     * 最近7天数据
     */
    public function days()
    {
        $first = strtotime("-7day");//第一天时间戳
        $second = strtotime("-6day");//第二天时间戳
        $third = strtotime("-5day");//第三天时间戳
        $fourth = strtotime("-4day");//第四天时间戳
        $five = strtotime("-3day");//第五天时间戳
        $sex = strtotime("-2day");//第六天时间戳
        $seven = strtotime("-1day");//第七天时间戳

        $data = [
            "first" => 0,
            "second" => 0,
            "third" => 0,
            "fourth" => 0,
            "five" => 0,
            "sex" => 0,
            "seven" => 0,
            "firstc" => 0,
            "secondc" => 0,
            "thirdc" => 0,
            "fourthc" => 0,
            "fivec" => 0,
            "sexc" => 0,
            "sevenc" => 0,
        ];
        $query = Db::name("member")->where("status", 4);
        if ($this->adminId > 1 ){
            $query=$query->where("admin_id",$this->adminId);
        }
        $rows=$query->select();
        foreach ($rows as $k => $row) {
            switch (true) {
                case $row['time'] > $first && $row['time'] < $second :
                    $data['first'] = $data['first'] + $row['money'];
                    $data['firstc']++;
                    break;
                case $row['time'] > $second && $row['time'] < $third;
                    $data['second'] = $data['second'] + $row['money'];
                    $data['secondc']++;
                    break;
                case $row['time'] > $third && $row['time'] < $fourth;
                    $data['third'] = $data['third'] + $row['money'];
                    $data['thirdc']++;
                    break;
                case $row['time'] > $fourth && $row['time'] < $five;
                    $data['fourth'] = $data['fourth'] + $row['money'];
                    $data['fourthc']++;
                    break;
                case $row['time'] > $five && $row['time'] < $sex;
                    $data['five'] = $data['five'] + $row['money'];
                    $data['fivec']++;
                    break;
                case $row['time'] > $sex && $row['time'] < $seven;
                    $data['sex'] = $data['sex'] + $row['money'];
                    $data['sexc']++;
                    break;
                case $row['time'] > $seven && $row['time'] < time();
                    $data['seven'] = $data['seven'] + $row['money'];
                    $data['sevenc']++;
                    break;
            }
        }


        return $data;

    }

    /*
     * 昨日数据
     */
    public function day()
    {
        $day = strtotime("-1day");//昨日时间戳

        $query = Db::name("member")->where("status", 4);
        $data = [
            "first" => 0,
            "firstc" => 0
        ];
        if ($this->adminId >1) {
            $query=$query->where("admin_id",$this->adminId);
        }
        $rows=$query->select();
        foreach ($rows as $row) {
            if ($row['time'] > $day && $row['time'] < time()) {
                $data['first'] = $data['first'] + $row['money'];
                $data['firstc']++;
            }
        }


        return $data;
    }
}
