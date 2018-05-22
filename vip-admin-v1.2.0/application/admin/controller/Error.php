<?php
namespace app\admin\controller;
use think\Request;

class Error
{
    public function index(Request $request)
    {
        //根据当前控制器名来判断要执行那个城市的操作
        return view('Public:tips',['msg'=>'没有该控制器->'.$request->controller()]);
    }

}
