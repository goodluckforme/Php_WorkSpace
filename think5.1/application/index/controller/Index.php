<?php

namespace app\index\controller;

use think\Controller;
use think\Db;

class Index extends Controller
{
    public function index($name = "马齐。。。。秀不秀？")
    {
        //给模板赋值
        $this->assign('name', $name);
        //输出模板
        return $this->fetch();
    }

    public function dbtest()
    {
        $data = Db::name('data')->find();
        $this->assign('result', $data);
        return $this->fetch();
    }

}
