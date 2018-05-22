<?php
namespace app\index\controller;

use think\Controller;
use think\Db;

class Index extends Controller {

    // 众筹首页
    public function index(){
        $version    = '1.2.0';              // 版本号
        $total      = 1600;                 // 众筹目标
        $nowTotal   = 0;                    // 现在用户众筹金额
        $gather     = Db::name('Gather')->select();
        foreach($gather as $v){
            $nowTotal += $v['money'];
        }
        // 百分率
        $percentage = $nowTotal / $total * 100;
        // 渲染视图
        return $this->fetch('',[
            'version'       => $version,    // 版本号
            'total'         => $total,      // 总
            'nowTotal'      => $nowTotal,   // 现
            'percentage'    => $percentage, // 百分率
            'gather'        => $gather      // 人员列表
        ]);
    }




}
