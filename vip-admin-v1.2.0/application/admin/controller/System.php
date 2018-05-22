<?php
namespace app\admin\controller;
use app\common\controller\AdminBase;

use think\Config;
use think\Db;

class System extends AdminBase {

    // 初始化
    public function _initialize(){
        // 初始化
        parent::_initialize();

    }

    // 基本信息
    public function index(){
        // 返回数据信息
        return $this->fetch('index',[
            'server'        => $_SERVER,
            'mysql_version' => $this->getMysqlVersion(),
            'mysql_name'    => Config::get('database.database'),
            'mysql_size'    => $this->getMysqlDbSize(),
            'config'        => $this->getConfig()
        ]);
    }

    // 基本配置
    public function config(){
        if($this->request->isPost()){
            // 获取数据
            $POST = $this->request->post();
            // 验证数据正确性
            $result = $this->validate($POST, 'Config');
            // 验证错误
            if ($result !== true) {
                $this->error($result);
            }else{
                if( Db::name('MustConfig')->update(array('id'=>1,'config'=>json_encode($POST))) ){
                    $this->success('修改成功');
                }else{
                    $this->error('修改失败');
                }
            }
        }else{
            // 获取数据
            $model =  Db::name('MustConfig')->find(1);
            // 解析数据
            $data = json_decode($model['config'],true);
            if($data){
                // 渲染视图并返回数据
                return $this->fetch('',$data);
            }else{
                // 渲染视图
                return $this->fetch();
            }
        }
    }

    // 权限组
    public function auth(){
        // 获取get请求数据
        $GET = $this->request->get();
        $search = isset($GET['search'])?$GET['search']:'';
        // 搜索请求
        if($this->request->isGet() && $search){
            // 获取数据
            $list = $this->getAuthGroup($search);
        }else{
            // 获取数据
            $list = $this->getAuthGroup();
        }
        // 渲染视图并返回数据
        return $this->fetch('',[
            'list'   => $list,
            'search' => $search
        ]);
    }

    // 修改权限组信息
    public function auth_edit(){
        if($this->request->post()){
            $data['status'] = 0;
            $data['msg'] = '未接收到数据';
            $POST = $this->request->post();
            // 修改操作
            if($this->editAuthGroup($POST)){
                $data['status'] = 1;
            }
            $data['msg'] = $this->msg;
            // 返回JSON
            $this->ajaxReturn( $data );
        }else{
            // 获取数据
            $GET = $this->request->get();
            if($GET['id']){
                // 渲染视图
                return $this->fetch('',[
                    'data'  => $this->getOneAuthGroup($GET['id'])
                ]);
            }else{
                return $this->fetch('Public:tips',['msg'=>'缺少必要数据']);
            }
        }
    }

    // 权限分配
    public function authAllocation(){
        // 获取菜单(0:获取status等于1的菜单,1获取所有状态的菜单////1:返回一级数组,0返回二级数组)
        $menu = $this->getMenu(0,1);
        // post请求
        if($this->request->isPost()) {
            // 获取请求数据
            $POST = $this->request->post();
            // 获取权限字符串
            $rules = $this->getAuthGroupRules(isset($POST['id'])?$POST['id']:1)['rules'];
            $newMenu = [];
            // 权限数组
            $ruleArr = explode(',', $rules);
            foreach ($menu as $k => $v) {
                $newMenu[$k]['id'] = $v['id'];
                $newMenu[$k]['name'] = $v['name'];
                $newMenu[$k]['url'] = $v['url'];
                $newMenu[$k]['status'] = 0;
                // 判断该权限是否在权限数组中
                if ($ruleArr && in_array($v['id'], $ruleArr)) {
                    $newMenu[$k]['status'] = 1;
                }
            }
            // 返回JSON
            $this->ajaxReturn(['data' => $newMenu]);
        }else{
            // 渲染视图
            return $this->fetch();
        }
    }

    // 增加或删除权限
    public function status(){
        // 数据
        $data['status'] = 0;
        $data['msg'] = '未请求数据';
        if($this->request->isPost()){
            // 获取数据
            $POST = $this->request->post();
            // 获取权限字符串
            $rules = $this->getAuthGroupRules($POST['aid'])['rules'];
            // 权限数组
            $ruleArr = explode(',', $rules);
            // 字符串
            $ruleStr = '';
            // 权限组内有即去除该权限
            if(in_array($POST['rid'],$ruleArr)){
                $i = array_search($POST['rid'],$ruleArr)?:0;
                // 删除该查找到的数据
                unset($ruleArr[$i]);
                $ruleStr = implode(',',$ruleArr);
            }elseif($POST['status']){
                // 添加该权限
                // 判断 合并数组 第一个数组
                $ruleStr = $rules ? implode(',',array_merge((array)$ruleArr,(array)$POST['rid'])) : $POST['rid'];
            }
            if( $this->upRuleStr($POST['aid'],$ruleStr) ){
                $data['status'] = 0;
                $data['msg'] = '更改成功';
            }else{
                $data['msg'] = '更改失败';
            }
        }
        // 返回JSON
        $this->ajaxReturn($data);
    }

    // 转出字符串对象
    public function treeJson(){
        // 拼装数据
        $tree = [];
        foreach($this->getAuthGroup() as $k=>$v){
            $tree[$k]['id'] = $v['id'];
            $tree[$k]['name'] = $v['title'];
        }
        $this->ajaxReturn($tree);
    }

    // 修改状态
    public function authStatus(){
        $data['status'] = 0;
        $data['msg'] = '未接收到请求';
        if($this->request->isPost()){
            $POST = $this->request->post();
            if($this->setTableStatus('MustAuthGroup',$POST['id'],$POST['status'])){
                $data['status'] = 1;
                $data['msg'] = '修改成功';
            }else{
                $data['msg'] = '修改失败';
            }
        }
        // 返回数据
        $this->ajaxReturn($data);
    }

    // 添加
    public function addAuth(){
        $data['status'] = 0;
        $data['msg'] = '未接收到请求';
        if($this->request->isPost()){
            $POST = $this->request->post();
            if($this->addAuthGroup($POST['title'],isset($POST['status'])?:'0')){
                $data['status'] = 1;
                $data['msg'] = '添加成功';
            }else{
                $data['msg'] = '添加失败';
            }
        }
        // 返回数据
        $this->ajaxReturn($data);
    }

    // 修改
    public function edit(){
        return $this->fetch();
    }

    // 删除权限组
    public function deleteAuthGroup(){
        if($this->commonDelete('MustAuthGroup')){
            $data['status'] = 1;
        }else{
            $data['status'] = 0;
        }
        $data['msg'] = $this->msg;
        // 返回数据
        $this->ajaxReturn($data);
    }


}
