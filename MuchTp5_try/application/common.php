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
function json($code,$msg="",$count,$data=array()){
    $result=array(
        'code'=>$code,
        'msg'=>$msg,
        'count'=>$count,
        'data'=>$data
    );
    //输出json
    echo json_encode($result);
    exit;
}
