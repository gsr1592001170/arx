<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/3
 * Time: 14:09
 */

namespace app\backend\validate;


use think\Validate;

class Visitor extends Validate
{
    protected $rule = [
        'name' => 'require',
        'tel' => ['require', 'unique:visitor', 'regex' => '0?(13|14|15|17|18|19)[0-9]{9}'],
        'room' => 'require',
    ];
    protected $field = [
        'name' => "访客姓名",
        'tel' => '联系方式',
        'room' => '探访房间号',
    ];

}