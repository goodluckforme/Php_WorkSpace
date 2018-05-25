<?php

namespace app\admin\controller\wifi\clock;

use app\common\controller\Backend;

/**
 * 打卡时间
 *
 * @icon fa fa-circle-o
 */
class Record extends Backend
{
    protected $noNeedLogin = ['index', 'add'];
    protected $noNeedRight = ['*'];
    /**
     * WifiClockRecord模型对象
     * @var \app\admin\model\WifiClockRecord
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = model('WifiClockRecord');
    }

    /**
     * 默认生成的控制器所继承的父类中有index/add/edit/del/multi五个基础方法、destroy/restore/recyclebin三个回收站方法
     * 因此在当前控制器中可不用编写增删改查的代码,除非需要自己控制这部分逻辑
     * 需要将application/admin/library/traits/Backend.php中对应的方法复制到当前控制器,然后进行修改
     */

    /**
     * 查看
     */
    public function index()
    {
        if ($this->request->isPost()) {
            //设置过滤方法
            $this->request->filter(['strip_tags']);
            //如果发送的来源是Selectpage，则转发到Selectpage
            if ($this->request->request('keyField')) {
                return $this->selectpage();
            }
            if (!isset($_POST['admin_id'])) {
                $result = array("code" => 100, "msg" => "查询失败", "data" => array("total" => 0, "list" => array()));
            } else {
                $admin_id = $this->request->request('admin_id');
                list($where, $sort, $order, $offset, $limit) = $this->buildparams();
                $total = $this->model
                    ->where($where)
                    ->order($sort, $order)
                    ->where('admin_id', 'in', [$admin_id])
                    ->count();

                $list = $this->model
                    ->where($where)
                    ->order($sort, $order)
                    ->limit($offset, $limit)
                    ->where('admin_id', 'in', [$admin_id])
                    ->select();
                $list = collection($list)->toArray();
                $msg = "查询成功";
                $code = 200;
                if ($total == 0) {
                    $code = 100;
                    $msg = "查询失败";
                }
                $result = array("code" => $code, "msg" => $msg, "data" => array("total" => $total, "list" => $list));
            }
            return json($result);
        } else {
            //设置过滤方法
            $this->request->filter(['strip_tags']);
            if ($this->request->isAjax()) {
                //如果发送的来源是Selectpage，则转发到Selectpage
                if ($this->request->request('keyField')) {
                    return $this->selectpage();
                }
                list($where, $sort, $order, $offset, $limit) = $this->buildparams();
                $total = $this->model
                    ->where($where)
                    ->order($sort, $order)
                    ->count();

                $list = $this->model
                    ->where($where)
                    ->order($sort, $order)
                    ->limit($offset, $limit)
                    ->select();

                $list = collection($list)->toArray();
                $result = array("total" => $total, "rows" => $list);
                return json($result);
            }
            return $this->view->fetch();
        }
    }

    /**
     * 添加
     */
    public function add()
    {
        if ($this->request->isPost()) {
            $admin_id = $this->request->post("admin_id");
            $clock_place = $this->request->post("clock_place");
            $lat = $this->request->post("lat");
            $lon = $this->request->post("lon");
            $wifiname = $this->request->post("wifiname");
            $wifi_distance = $this->request->post("wifi_distance");
            $gps_distance = $this->request->post("gps_distance");
            $params = array(
                "admin_id" => $admin_id,
                "clock_place" => $clock_place,
                "lat" => $lat,
                "lon" => $lon,
                "wifiname" => $wifiname,
                "wifi_distance" => $wifi_distance,
                "gps_distance" => $gps_distance
            );
            if ($params) {
                if ($this->dataLimit && $this->dataLimitFieldAutoFill) {
                    $params[$this->dataLimitField] = $this->auth->id;
                }
                try {
                    //是否采用模型验证
                    if ($this->modelValidate) {
                        $name = basename(str_replace('\\', '/', get_class($this->model)));
                        $validate = is_bool($this->modelValidate) ? ($this->modelSceneValidate ? $name . '.add' : true) : $this->modelValidate;
                        $this->model->validate($validate);
                    }
                    $result = $this->model->allowField(true)->save($params);
                    if ($result !== false) {
                        return json(array("code" => 200, "msg" => "打卡成功", "data" => ["list" => array()]));
                    } else {
                        return json(array("code" => 100, "msg" => $this->model->getError(), "data" => ["list" => array()]));
                    }
                } catch (\think\exception\PDOException $e) {
                    return json(array("code" => 100, "msg" => $e->getMessage(), "data" => ["list" => array()]));
                }
            }
            return json(array("code" => 180, "msg" => "缺少必要参数", "data" => ["list" => array()]));
        }
        return json(array("code" => 100, "msg" => "添加打卡记录失败", "data" => ["list" => array()]));
    }
}
