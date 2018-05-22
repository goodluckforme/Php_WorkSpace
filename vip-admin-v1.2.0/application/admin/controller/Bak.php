<?php
namespace app\admin\controller;
use app\common\controller\AdminBase;

use think\Config;
use think\Db;
use org\Back;

class Bak extends AdminBase{

    // 初始化
    public function _initialize(){
        // 初始化
        parent::_initialize();
    }

    // 首页
    public function index(){
        if($this->request->isPost()){
            // 查询列表
            $data = Db('MustBackSql')->where(['status'=>1])->select();
            // 返回json
            $this->ajaxReturn(['data'=>$data]);
        }else{
            // 渲染视图
            return $this->fetch();
        }
    }

    // 备份
    public function back(){
        // 数据
        $data['status'] = 0;
        $data['msg'] = '未接收到请求';
        // 是否有请求
        if($this->request->isPost()){
            // 备份类
            $bak = new Back();
            // 获取表名
            $tables = $bak->getTables();
            // 日期
            $day = date("Y-m-d",time());
            // 随机数据
            $time = substr(time(),6,4);
            // 文件路径
            $filePath = 'static/admin/sql/back_'.$day.'_'.$time.'.sql';
            // 将表结构写入到文件
            $structure = $bak->structureToFile($tables,$filePath);
            // 将表数据写入到文件
            $flag = $bak->tableDataToFile($tables,$filePath);
            if($structure && $flag){
                $data['status'] = 1;
                $data['msg'] = '备份成功';
                // 添加数据到数据库中
                $info['url'] = $filePath;
                $info['time'] = date("Y-m-d H:i:s",time());
                $info['status'] = 1;
                // 添加
                Db::name('MustBackSql')->insert($info);
            }else{
                $data['msg'] = '备份出错';
            }
        }
        // 返回json
        $this->ajaxReturn($data);
    }

    // 删除备份
    public function delete(){
        // 获取请求参数
        $POST = $this->request->post();
        // 删除sql文件
        $this->sqlDelete('MustBackSql',$POST['ids']);
        // 通用删除方法
        if($this->commonDelete('MustBackSql')){
            $data['status'] = 1;
        }else{
            $data['status'] = 0;
        }
        // 返回的消息
        $data['msg'] = $this->msg;
        // 返回json
        $this->ajaxReturn($data);
    }
}
