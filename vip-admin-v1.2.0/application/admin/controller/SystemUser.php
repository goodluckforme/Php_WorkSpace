<?php
namespace app\admin\controller;
use app\common\controller\AdminBase;

class SystemUser extends AdminBase{

    // 初始化
    public function _initialize(){
        // 初始化
        parent::_initialize();
    }

    // 首页
    public function index(){
        // 判断是否post请求
        if($this->request->isPost()){
            // 搜索数据
            $POST = $this->request->post();
            $search = isset($POST['search'])?$POST['search']:'';
            // 获取系统管理员数据
            $this->ajaxReturn( ['data'=>$this->getSystemUser($search)] );
        }else{
            // 获取权限组权限
            $authGroup = $this->getAuthGroup();
            // 渲染视图
            return $this->fetch('',[
                'authGroup' => $authGroup
            ]);
        }
    }

    // 添加
    public function add(){
        $data['status'] = 0;
        $data['msg'] = '未请求数据';
        // 登录请求
        if($this->request->isPost()){
            // 获取POST数据
            $POST = $this->request->only(['account', 'password', 're_password', 'group']);
            // 验证数据正确性
            $result = $this->validate($POST, 'AddSystemUser');
            // 验证错误
            if ($result !== true) {
                $this->error($result);
            }else{
                // 添加数据
                $ins = $this->addSystemUser($POST);
                if($ins){
                    // 添加用户到权限组
                    $this->addAuthGroupAccess(['sid'=>$ins,'gid'=>$POST['group']]);
                    // 添加成功信息
                    $data['status'] = 1;
                    $data['msg'] = '添加成功';
                }else{
                    // 失败信息
                    $data['msg'] = '添加失败';
                }
            }
        }
        // 返回JSON
        $this->ajaxReturn($data);
    }

    // 系统用户状态修改
    public function systemUserStatus(){
        $data['status'] = 0;
        $data['msg'] = '未接收到请求';
        if($this->request->isPost()){
            $POST = $this->request->post();
            // 设置状态
            if($this->setTableStatus('MustSystemUser',$POST['id'],$POST['status'])){
                $data['status'] = 1;
                $data['msg'] = '修改成功';
            }else{
                $data['msg'] = '修改失败';
            }
        }
        // 返回数据
        $this->ajaxReturn($data);
    }

    // 修改信息
    public function edit(){
        // 提交更改数据
        if($this->request->isPost()){
            $data['status'] = 0;
            $data['msg'] = '未接收数据';
            // 获取修改好的数据
            $POST = $this->request->post();
            // 验证数据正确性
            $result = $this->validate($POST, 'MustSystemUserEdit');
            // 验证错误
            if ($result !== true) {
                $this->error($result);
            }else{
                if($this->editSystemUser($POST)){
                    $data['status'] = 1;
                }
                $data['msg'] = $this->msg;
            }
            //返回JSON
            $this->ajaxReturn( $data );
        }else{
            // 获取get
            $GET = $this->request->get();
            // 渲染模板并返回数据
            return $this->fetch('',[
                'authGroup'     => $this->getAuthGroup(),
                'data'          => $this->getOneSystemUser($GET['id'])
            ]);
        }
    }

    // 修改密码
    public function edit_password(){
        // 提交更改数据
        if($this->request->isPost()) {
            $data['status'] = 0;
            $data['msg'] = '未接收数据';
            // 获取修改好的数据
            $POST = $this->request->post();
            // 验证数据正确性
            $result = $this->validate($POST, 'MustSystemUserPasswordEdit');
            // 验证错误
            if ($result !== true) {
                $this->error($result);
            }else{
                // 验证旧密码正确性
                if($this->checkOldPassword($POST)){
                    // 修改密码
                    if($this->editPassword($POST)){
                        // 修改返回状态
                        $data['status'] = 1;
                    }
                }
            }
            // 返回信息
            $data['msg'] = $this->msg;
            // 返回JSON
            $this->ajaxReturn( $data );
        }else{
            // 渲染模板
            return $this->fetch();
        }
    }

    // 删除系统用户
    public function delete(){
        // 通用删除方法
        if($this->commonDelete('MustSystemUser')){
            $data['status'] = 1;
        }else{
            $data['status'] = 0;
        }
        // 返回的消息
        $data['msg'] = $this->msg;
        // 返回JSON
        $this->ajaxReturn($data);
    }

}
