<?php
namespace app\admin\controller;
use app\common\controller\AdminBase;

class User extends AdminBase{

    // 初始化
    public function _initialize(){
        // 初始化
        parent::_initialize();

    }

    // 首页
    public function index(){
        return $this->fetch('index',['name'=>'thinkphp!!!']);
    }

    // 权限
    public function auth(){
        return $this->fetch();
    }

    // 系统用户
    public function system(){
        // 判断是否post请求
        if($this->request->isPost()){
            // 返回JSON
            $this->ajaxReturn(['data'=>$this->getSystemUser()]);
        }else{
            // 渲染视图
            return $this->fetch();
        }
    }

    // 添加
    public function add(){
        return $this->fetch();
    }

    // 添加
    public function edit_password(){
        return $this->fetch();
    }

    // 修改
    public function edit(){
        return $this->fetch();
    }




}
