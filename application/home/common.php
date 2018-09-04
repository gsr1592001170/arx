<?php
function get_json($status,$msg="",$data=null){
    return json([
        "status"=>$status,
        "msg"=>$msg,
        "data"=>$data
    ]);
}
