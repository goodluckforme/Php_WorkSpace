<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/15
 * Time: 12:33
 */


namespace app\api\controller;


use think\Controller;

class Name extends Controller
{
    public function index()
    {
        return $this->fetch();
    }

    public function school()
    {
        $rs = db('forum_posts')->select();
        $rs1 = json(0, '数据返回成功', 1000, $rs);
        dump($rs1);
        die;//打印出来
        return $this->fetch('index');
    }

    public function getcontent()
    {
        $rs = db('forum_posts')->select();
        $this->assign('forum_post', $rs[0]);
        return $this->fetch('index');
    }

    public function run(){
        $rs = db('forum_posts')->select();
        $rs1 = json(200, '查询成功', 10, $rs);
        return $rs1;
    }
}