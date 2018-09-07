<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
function get_json($status,$msg="",$data=null){
    return json([
        "status"=>$status,
        "msg"=>$msg,
        "data"=>$data
    ]);
}

function get_row($str){
    $row = [
        "create_time"=>time(),
        "content"=>$str,
    ];

    return $row;
}