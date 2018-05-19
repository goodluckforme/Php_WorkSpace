<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/15
 * Time: 11:19
 */

namespace app\api\controller;


use think\Controller;


class UserInfo extends Controller
{
    public function  index(){
        return $this->fetch();
    }
    public function school()
    {
        $rs=db('school')->select();
        $rs1=json(0,'数据返回成功',1000,$rs);
        dump($rs1);die;//打印出来
        return $this -> fetch();
    }

}