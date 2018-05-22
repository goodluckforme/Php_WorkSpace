<?php
namespace app\common\controller;
use think\Controller;

use think\Db;
use think\Config;
use think\Session;

class Base extends Controller {

    // 初始化
    public function _initialize(){
        // 添加日志
        $this->log();
    }

    // 日志
    public function log(){
        if(Session::has('vip_admin.area')){
            Session::set('vip_admin.area',get_ip_location($this->request->ip()));
        }
        // 收集数据
        $temp['us_id']              = Session::get('vip_admin.id');
        $temp['operation_position'] = $this->request->module().'/'.$this->request->controller().'/'.$this->request->action(); // 操作定位
        $temp['operation_ip']       = $this->request->ip();                     // 客户端ip
        $temp['operation_ip_area']  = Session::has('vip_admin.area') ? Session::get('vip_admin.area') : get_ip_location($this->request->ip());    // ip地域
        $temp['is_mobile']          = $this->request->isMobile()?'是':'否';      // 是否是手机访问
        $temp['time']               = date('Y-m-d H:i:s',time());               // 操作访问时间
        // 验证数据正确性
        $result = $this->validate($temp, 'Log');
        if ($result !== true) {
            $this->error($result);
        }else{
            Db::name('MustSystemLog')->insert($temp);
        }
    }

    /**
     * Ajax方式返回数据到客户端
     * @access protected
     * @param mixed $data 要返回的数据
     * @param String $type AJAX返回数据格式
     * @param int $json_option 传递给json_encode的option参数
     * @return void
     */
    protected function ajaxReturn($data,$type='',$json_option=0){
        if(empty($type)) $type  =   Config::get('default_ajax_return');
        switch (strtoupper($type)){
            case 'JSON' :
                // 返回JSON数据格式到客户端 包含状态信息
                header('Content-Type:application/json; charset=utf-8');
                exit(json_encode($data,$json_option));
            case 'XML'  :
                // 返回xml格式数据
                header('Content-Type:text/xml; charset=utf-8');
                exit(xml_encode($data));
            case 'JSONP':
                // 返回JSON数据格式到客户端 包含状态信息
                header('Content-Type:application/json; charset=utf-8');
                $handler  =   isset($_GET[C('VAR_JSONP_HANDLER')]) ? $_GET[C('VAR_JSONP_HANDLER')] : C('DEFAULT_JSONP_HANDLER');
                exit($handler.'('.json_encode($data,$json_option).');');
            case 'EVAL' :
                // 返回可执行的js脚本
                header('Content-Type:text/html; charset=utf-8');
                exit($data);
            default     :
                // 返回JSON数据格式到客户端 包含状态信息
                header('Content-Type:application/json; charset=utf-8');
                exit(json_encode($data,$json_option));
        }
    }


}
