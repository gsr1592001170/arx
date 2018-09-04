<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/3
 * Time: 14:52
 */

namespace app\backend\validate;


use think\Validate;

class User extends Validate
{
    protected $rule = [
        'username'  =>  'require',
        'tel'=>['require','unique:user','regex'=>'0?(13|14|15|17|18|19)[0-9]{9}'],
        'source'=>'require',
        'hospital'=>'require',
        'yuchanqi'=>'require'
    ];
    protected $field=[
        'username'=>"姓名",
        'tel'=>'联系方式',
        'source'=>'来源',
        'hospital'=>'产检医院',
        'yuchanqi'=>'预产期',
    ];
}