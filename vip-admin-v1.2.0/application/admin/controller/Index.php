<?php
namespace app\admin\controller;
use app\common\controller\AdminBase;

use think\Config;
use think\Db;
use think\Session;

class Index extends AdminBase{

    // 初始化
    public function _initialize(){
        // 初始化
        parent::_initialize();

    }

    // 首页
    public function index(){
        // 渲染视图并输出数据
        return $this->fetch('index',[
            'config'    => $this->getConfig(),
            'menu'      => $this->getMenu()
        ]);
    }

    // 欢迎页
    public function welcome(){
        return $this->fetch('welcome');
    }




}
