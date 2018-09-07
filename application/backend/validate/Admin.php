<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/4
 * Time: 15:43
 */

namespace app\backend\validate;


use think\Validate;

class Admin extends Validate
{
    protected $rule = [
        'username'  =>  'require',
        'password'  =>  'require',
        'tel'       =>   ['require','unique:admin','regex'=>'0?(13|14|15|17|18|19)[0-9]{9}'],
        'name'=>'require'
    ];

    protected $field=[
        'username'=>"账号",
        'password'=>'密码',
        'tel'=>'电话号码',
        'name'=>'姓名'
    ];

    protected $scene = [
        'login'  =>  ['username','password'],
        'add'  =>  ['name','tel','password'],
    ];
}