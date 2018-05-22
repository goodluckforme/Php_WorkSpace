<?php
namespace app\common\controller;

use org\Auth;
use think\Db;
use think\Config;
use think\Session;

class AdminBase extends Base{

    // 返回信息
    public $msg;

    // 初始化
    public function _initialize(){
        // 检测登录
        $this->isLogin();
        // 检查权限
        $this->checkAuth();
        // 初始化
        parent::_initialize();
    }

    // 空操作
    public function _empty(){
        return view('Public:404');
    }

    // 检测登录
    public function isLogin(){
        // 如果没有登录
        if( !Session::get('vip_admin.id') ){
            // 跳转到登录
            $this->redirect('Login/index');
        }
    }

    // 权限检查
    protected function checkAuth(){
        // 获取模块/控制器/方法
        $module     = $this->request->module();
        $controller = $this->request->controller();
        $action     = $this->request->action();
        // 排除权限
        $not_check = ['admin/login/index','admin/Index/index'];
        // 排除
        if (!in_array($module . '/' . $controller . '/' . $action, $not_check)) {
            $auth = new Auth();
            $sid = Session::get('vip_admin.id');
            // 权限验证
            if (!$auth->check($module . '/' . $controller . '/' . $action, $sid) && $sid != 1) {
                //
                $this->fetch('public/tips',['msg'=>'没有权限']);
            }
        }
    }

    // 获取侧边栏菜单(1:全部/0:正常,1:直接返回一级数组/0:返回二级数组)
    protected function getMenu($flag = 0,$list = 0){
        $menu = $where = [];
        if(!$flag){
            $where['status'] = 1;
        }
        $sid = Session::get('vip_admin.id');
        $auth     = new Auth();
        $auth_rule_list = Db::name('MustAuthRule')
                          ->field(['id','name','url','icon','pid','order','status'])
                          ->where( $where )->order(['order' => 'DESC', 'id' => 'ASC'])
                          ->select();
        // 返回一级数组
        if($list){
            return $auth_rule_list;
        }else{
            // 返回二级数组
            foreach ($auth_rule_list as $value) {
                if ($auth->check($value['name'], $sid) || $sid == 1) {
                    $menu[] = $value;
                }
            }
            // 不等于空构建树目录并返回
            return !empty($menu) ? treeArray($menu) : [];
        }

    }

    // 获取搜索的菜单数据
    protected function getSearchMenu($map){
        return Db::name('MustAuthRule')
               ->field(['id','name','url','icon','pid','order','status'])
               ->where( 'name', 'like', '%'.trim($map).'%' )
               ->order(['order' => 'DESC', 'id' => 'ASC'])
               ->select();
    }


    // 返回数据库版本
    public function getMysqlVersion(){
        $version = Db::query("select version() as ver");
        return $version[0]['ver'];
    }

    // 返回数据库大小
    public function getMysqlDbSize(){
        $sql = "SHOW TABLE STATUS FROM ".Config::get('database.database');
        $tblPrefix = Config::get('database.prefix');
        if($tblPrefix != null) {
            $sql .= " LIKE '{$tblPrefix}%'";
        }
        $row = Db::query($sql);
        $size = 0;
        foreach($row as $value) {
            $size += $value["Data_length"] + $value["Index_length"];
        }
        return round(($size/1048576),2).'M';
    }

    // 获取基本配置数据
    public function getConfig(){
        // 获取配置
        $config =  Db::name('MustConfig')->find(1);
        // 解析配置并返回数组
        return json_decode($config['config'],true);
    }

    // 获取系统用户数据
    public function getSystemUser($search){
        // 搜索条件
        $where = [];
        if($search){
            $where['account'] = ['like','%'.trim($search).'%'];
        }
        // 关联join
        $join = [
            [[Db::name('MustAuthGroupAccess')->getTable() => 'aga'],'su.id = aga.sid'],
            [[Db::name('MustAuthGroup')->getTable() => 'ag'],'aga.gid = ag.id']
        ];
        // 返回数据
        return Db::name('MustSystemUser')
            ->alias('su')
            ->field(['su.id','account','ag.title auth_group_name','last_login_time','last_login_ip','create_time','su.status'])
            ->join( $join )
            ->where( $where )
            ->select();
    }

    // 获取单个系统用户数据
    public function getOneSystemUser($id){
        if(!$id){
            return false;
        }
        $join = [
            [[Db::name('MustAuthGroupAccess')->getTable() => 'aga'],'su.id = aga.sid']
        ];
        return Db::name('MustSystemUser')
               ->alias('su')
               ->field(['su.id','aga.gid','account','status'])
               ->join( $join )
               ->find($id);
    }

    // 根据ID获取系统用户账号
    public function getSystemUserAccount($sid){
        // 检测登录
        $this->isLogin();
        // 查询数据库
        $data = Db::name('MustSystemUser')->filed(['account'])->find($sid);
        // 返回账号
        return $data['account'];
    }

    // 获取权限组
    public function getAuthGroup($search = ''){
        // model对象
        $model = Db::name('MustAuthGroup');
        // 判断是否有搜索数据
        if($search){
            return $model->where( 'title','like','%'.trim($search).'%' )->select();
        }else{
            return $model->select();
        }
    }

    // 获取单个权限组信息
    public function getOneAuthGroup($id){
        if(!$id){
            return false;
        }
        return Db::name('MustAuthGroup')->find($id);
    }

    //获取权限组rules
    public function getAuthGroupRules($aid){
        return Db::name('MustAuthGroup')->field(['rules'])->find($aid);
    }

    // 获取单个菜单数据
    public function getOneAuthRule($id){
        if(!$id){
            return false;
        }
        // 查询数据并返回
        return Db::name('MustAuthRule')->find($id);
    }


    // 修改数据状态
    public function setTableStatus($name,$id,$status){
        // 修改数据库数据
        if($num = Db::name($name)->where(['id'=>$id])->update(['status'=>$status ?: 0])){
            // 返回状态
            $this->msg = '操作成功';
            return $num;
        }
        // 返回状态
        $this->msg = '操作失败';
        return false;
    }

    // 添加权限组
    public function addAuthGroup($title,$status){
        if($title){
            // 添加
            $ins = Db::name('MustAuthGroup')->insert([
                'title'  => $title,
                'status' => isset($status)?$status:0
            ]);
            if($ins){
                $this->msg = '添加成功';
                return true;
            }else{
                $this->msg = '操作失败';
            }
        }else{
            $this->msg = '名称不能为空';
        }
        return false;
    }

    // 修改权限组
    public function editAuthGroup($post){
        if($post){
            // 添加
            $ins = Db::name('MustAuthGroup')->update([
                'id'        => $post['id'],
                'title'     => $post['title'],
                'status'    => isset($post['status'])?$post['status']:0
            ]);
            if($ins){
                $this->msg = '操作成功';
                return true;
            }else{
                $this->msg = '操作失败';
            }
        }else{
            $this->msg = '数据不能为空';
        }
        return false;
    }


    // 添加系统用户
    public function addSystemUser($post){
        // 添加数据 成功返回自增主键
        $ins = Db::name('MustSystemUser')->insertGetId([
            'account'       => $post['account'],
            'password'      => md5($post['password'].Config::get('key')),
            'create_time'   => date('Y-m-d H:i:s',time()),
            'status'        => isset($post['status'])?:'0'
        ]);
        // 返回是否添加成功
        return $ins ? $ins : false;
    }

    // 修改系统用户
    public function editSystemUser($post){
        // 添加数据 成功返回自增主键
        $ins = Db::name('MustSystemUser')->update([
            'id'            => $post['id'],
            'account'       => $post['account'],
            'status'        => isset($post['status'])?:'0'
        ]);
        // 修改该用户所在权限组
        $agaModel = Db::name('MustAuthGroupAccess');    // model对象
        // 查询是否有改数据
        $aga = $agaModel->where(['sid'=>$post['id']])->find();
        if($aga){
            // 删除该数据
            $agaModel->delete($aga['id']);
        }
        // 重新赋值或添加新值
        $add = $agaModel->insert([
            'sid'   => $post['id'],
            'gid'   => $post['gid']
        ]);
        if($add && $ins){
            $this->msg = '操作成功';
            return true;
        }else{
            $this->msg = '操作失败';
            return false;
        }
    }

    // 添加用户关联权限组
    public function addAuthGroupAccess($data){
        $ins = 0;
        if(is_array($data)){
            // 对象
            $model = Db::name('MustAuthGroupAccess');
            // 查询是否有设置过改用户关联权限组
            $info = $model->where($data)->find();
            if($info){
                // 有相同数据就删除
                $model->delete($info['id']);
            }else{
                // 添加数据
                $ins = Db::name('MustAuthGroupAccess')->insert($data);
            }
        }
        // 返回数据
        return $ins?$ins:false;
    }

    // 添加菜单
    public function addMenu($data){
        if($data){
            // 添加数据
            $ins = Db::name('MustAuthRule')->insertGetId([
                'name'      => $data['name'],
                'pid'       => isset($data['pid'])?$data['pid']:0,
                'url'       => $data['url'],
                'icon'      => isset($data['icon'])?$data['icon']:'',
                'order'     => isset($data['order'])?$data['order']:0,
                'status'    => isset($data['status'])?$data['status']:0,
            ]);
            if($ins){
                $this->msg = '添加成功';
                return $ins;
            }else{
                $this->msg = '添加失败';
            }
        }else{
            $this->msg = '数据不能为空';
        }
        return false;
    }

    // 修改菜单
    public function editMenu($data){
        if($data){
            // 添加数据
            $ins = Db::name('MustAuthRule')->update([
                'id'        => $data['id'],
                'name'      => $data['name'],
                'pid'       => isset($data['pid'])?$data['pid']:0,
                'url'       => $data['url'],
                'icon'      => isset($data['icon'])?$data['icon']:'',
                'order'     => isset($data['order'])?$data['order']:0,
                'status'    => isset($data['status'])?$data['status']:0,
            ]);
            if($ins){
                $this->msg = '修改成功';
                return $ins;
            }else{
                $this->msg = '修改失败';
            }
        }else{
            $this->msg = '数据不能为空';
        }
        return false;
    }

    // 修改权限
    public function upRuleStr($id,$str){
        // 修改
        return Db::name('MustAuthGroup')->update([
            'id'    => $id,
            'rules' => $str
        ]);
    }

    // 通用删除方法
    public function commonDelete($tableName){
        // 数据
        $this->msg = '未接收到请求';
        // 是否有请求
        if($this->request->isPost()){
            // 获取请求参数
            $POST = $this->request->post();
            // 删除并删除成功
            if(Db::name($tableName)->where("id in (".$POST['ids'].")")->delete()){
                $this->msg = '操作成功';
                return true;
            }else{
                $this->msg = '操作失败';
                return false;
            }
        }
    }

    // 删除sql文件
    public function sqlDelete($tableName,$ids){
        // 查询数据
        $list = Db::name($tableName)->field(['url'])->where("id in (".$ids.")")->select();
        // 删除存在的备份文件
        if($list){
            // 循环获得删除文件路径
            foreach($list as $v){
                // 删除文件
                unlink($v['url']);
            }
        }
    }

    // 检查旧密码
    public function checkOldPassword($post){
        if(!$post){
            $this->msg = '缺少必要数据';
            return false;
        }
        $systemUser = Db::name('MustSystemUser')->find(Session::get('vip_admin.id'));
        if(md5($post['old_password'].Config::get('key')) == $systemUser['password']){
            $this->msg = '检查通过';
            return true;
        }else{
            $this->msg = '旧密码错误';
            return false;
        }
    }

    // 修改旧密码
    public function editPassword($post){
        if(!$post){
            $this->msg = '缺少必要数据';
            return false;
        }
        // 修改
        $data = Db::name('MustSystemUser')->update([
            'id'    => Session::get('vip_admin.id'),
            'password'  => md5($post['password'].Config::get('key'))
        ]);
        // 判断
        if($data){
            $this->msg = '更新成功';
            return true;
        }else{
            $this->msg = '更新出错';
            return false;
        }
    }


}
