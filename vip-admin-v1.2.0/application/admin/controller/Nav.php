<?php
namespace app\admin\controller;

use app\common\controller\AdminBase;

class Nav extends AdminBase {

    // 初始化
    public function _initialize(){
        // 初始化
        parent::_initialize();

    }

    // 首页
    public function index(){
        $data = [];
        // 获取get请求数据
        $GET = $this->request->get();
        $search = isset($GET['search'])?$GET['search']:'';
        // 搜索请求
        if($this->request->isGet() && $search){
            // 获取搜索数据
            $data = $this->getSearchMenu($search);
        }else{
            // 普通菜单数据
            $data = $this->getMenu(1);
        }
        // 渲染视图
        return $this->fetch('index',['menu'=>$data,'search'=>$search]);
    }

    // 添加
    public function add(){
        $data['status'] = 0;
        $data['msg'] = '未接收到请求';
        if($this->request->isPost()){
            $POST = $this->request->post();
            // 验证数据正确性
            $result = $this->validate($POST, 'MustAuthRule');
            // 验证错误
            if ($result !== true) {
                $this->error($result);
            }else{
                // 添加数据
                if($this->addMenu($POST)){
                    $data['status'] = 1;
                }
                $data['msg'] = $this->msg;
            }

        }
        // 返回数据
        $this->ajaxReturn($data);
    }

    // 修改
    public function edit(){
        // 是否提交更改数据
        if($this->request->isPost()){
            $POST = $this->request->post();
            // 验证数据正确性
            $result = $this->validate($POST, 'MustAuthRuleEdit');
            // 验证错误
            if ($result !== true) {
                $this->error($result);
            }else{
                // 修改数据
                if($this->editMenu($POST)){
                    $data['status'] = 1;
                }
                $data['msg'] = $this->msg;
            }
            // 返回JSON
            $this->ajaxReturn($data);
        }else{
            // 获取id
            $GET = $this->request->get();
            // 渲染模板并返回数据
            return $this->fetch('',[
                'menu'  => $this->getMenu(1),
                'info'  => $this->getOneAuthRule($GET['rid'])
            ]);
        }

    }

    // 删除
    public function delete(){
        // 通用删除方法
        if($this->commonDelete('MustAuthRule')){
            $data['status'] = 1;
        }else{
            $data['status'] = 0;
        }
        // 返回的消息
        $data['msg'] = $this->msg;
        // 返回JSON
        $this->ajaxReturn($data);
    }

    // 修改状态
    public function status(){
        $data['status'] = 0;
        $data['msg'] = '未接收到请求';
        if($this->request->isPost()){
            $POST = $this->request->post();
            if($this->setTableStatus('MustAuthRule',$POST['id'],$POST['status'])){
                $data['status'] = 1;
                $data['msg'] = '修改成功';
            }else{
                $data['msg'] = '修改失败';
            }
        }
        // 返回数据
        $this->ajaxReturn($data);
    }


}
