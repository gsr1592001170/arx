<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/3
 * Time: 14:52
 */

namespace app\home\validate;


use think\Validate;

class User extends Validate
{
    protected $rule = [
        'username'  =>  'require',
        'tel'=>['unique:user','regex'=>'0?(13|14|15|17|18|19)[0-9]{9}'],
        'source'=>'require',
        'visit_time'=>'require'
    ];
    protected $field=[
        'username'=>"姓名",
        'tel'=>'联系方式',
        'source'=>'来源',
        'visit_time'=>'预约时间'
    ];
    protected $scene = [
        'reg'  =>  ['username','tel'=>['regex'=>'0?(13|14|15|17|18|19)[0-9]{9}'],'source'],
        'makereg'  =>  ['username','tel','visit_time'],
    ];
}