<?php
namespace app\admin\controller;

use app\common\controller\AdminBase;
use think\Db;

class Log extends AdminBase{
    /**
     * Log
     * 日志操作类
     */

    // 初始化
    public function _initialize(){
        // 初始化
        parent::_initialize();
    }

    // 首页
    public function index(){
        // 请求数据
        if($this->request->isPost()){
            $where = [];
            // 搜索数据
            $POST = $this->request->post();
            $search = isset($POST['search'])?$POST['search']:'';
            if($search){
                $where['su.account'] = ['like','%'.trim($search).'%'];
            }
            // 筛选
            $field = ['l.id,su.account','operation_position','operation_ip','operation_ip_area','is_mobile','time'];
            // 链接查询
            $join = [[[Db::name('MustSystemUser')->getTable() => 'su'],'l.us_id=su.id','LEFT']];
            // 查询数据
            $data['data'] = Db::name('MustSystemLog')->alias('l')->field( $field )->join( $join )->where( $where )->select();
            // 返回JSON
            $this->ajaxReturn($data);
        }else{
            // 渲染视图
            return $this->fetch();
        }
    }

    // 删除
    public function delete(){
        // 通用删除方法
        if($this->commonDelete('MustSystemLog')){
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
