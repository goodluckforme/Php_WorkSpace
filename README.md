# Php_WorkSpace<br/>
PHP练手项目   预计30天内完成一个网站<br/>

目前正在熟悉Tpo5的框架  基础还不是很牢固。<br/>
不过抱着入门经典的书读 感觉一年都不会有效果。<br/>
所以这边直接建一个TP5项目。<br/>
就像当年啥都不懂 上来就建一个Android项目一样 <br/>
开始也许会举步维艰  但是别忘了咱们都是从便向百度编程过来的 <br/>
想想也挺欣慰的  百度解决了我们98%的问题。剩下2%是在编码中体会到的<br/>
当年 Android 可以从无到有 我觉得PHP我也可以。<br/>
目前正在熟悉项目架构，初步目标定在做一个管理后台模仿（宝塔山）<br/>
真的还是实践出真知  读书固好 可效率太低 不能再拖了 30天内搞定<br/>



针对FastAdmin的修改步骤

1.修改主界面的不需要的部分
2.尝试修改第一次安装的数据库(最好不要这样)但至少可以改个前缀
	2.2 自己建一张表  代码建立 模仿FastAdmin的语法
3.尝试建立一张表  用户打卡记录的表  应该很简单对吧？（重要）
4.API文档很完美 以后就照着这个来http://www.mfastadmin.com/api.html


在USer表下建立一个wificolock方法
http://www.mfastadmin.com/index.php/api/user/wificolock

  public function wificolock()
{
	$username = $this->request->request('username');
	$clock_place = $this->request->request('clock_place');
	$this->success('返回成功', ['action' => '打卡成功','username'=>$username,'clock_place'=>$clock_place]);
}

增加查询语句

在此之前我发现更加简单的写法 如下：

创建 	 GRUD 
D:\Apache24\htdocs\Php_WorkSpace\MfastAdmin>php think crud -t fa_wifi_clock_record
Build Successed

删除	 GRUD
D:\Apache24\htdocs\Php_WorkSpace\MfastAdmin>php think crud -t fa_wifi_clock_record

D:\Apache24\htdocs\Php_WorkSpace\MfastAdmin>php think crud -t fa_wifi_clock_record -d 1
D:\Apache24\htdocs\Php_WorkSpace\MfastAdmin\application\admin\controller\wifi\clock\Record.php
D:\Apache24\htdocs\Php_WorkSpace\MfastAdmin\application\admin\model\WifiClockRecord.php
D:\Apache24\htdocs\Php_WorkSpace\MfastAdmin\application\admin\validate\WifiClockRecord.php
D:\Apache24\htdocs\Php_WorkSpace\MfastAdmin\application\admin\view\wifi/clock/record\add.html
D:\Apache24\htdocs\Php_WorkSpace\MfastAdmin\application\admin\view\wifi/clock/record\edit.html
D:\Apache24\htdocs\Php_WorkSpace\MfastAdmin\application\admin\view\wifi/clock/record\index.html
D:\Apache24\htdocs\Php_WorkSpace\MfastAdmin\application\admin\lang\zh-cn\wifi/clock/record.php
D:\Apache24\htdocs\Php_WorkSpace\MfastAdmin\public\assets\js\backend\wifi/clock/record.js
Are you sure you want to delete all those files?  Type 'yes' to continue:

删除框架自带的 test GRUD
D:\Apache24\htdocs\Php_WorkSpace\MfastAdmin>php think crud -t test -d 1
D:\Apache24\htdocs\Php_WorkSpace\MfastAdmin\application\admin\controller\Test.php
D:\Apache24\htdocs\Php_WorkSpace\MfastAdmin\application\admin\model\Test.php
D:\Apache24\htdocs\Php_WorkSpace\MfastAdmin\application\admin\validate\Test.php
D:\Apache24\htdocs\Php_WorkSpace\MfastAdmin\application\admin\view\test\add.html
D:\Apache24\htdocs\Php_WorkSpace\MfastAdmin\application\admin\view\test\edit.html
D:\Apache24\htdocs\Php_WorkSpace\MfastAdmin\application\admin\view\test\index.html
D:\Apache24\htdocs\Php_WorkSpace\MfastAdmin\application\admin\lang\zh-cn\test.php
D:\Apache24\htdocs\Php_WorkSpace\MfastAdmin\public\assets\js\backend\test.js
Are you sure you want to delete all those files?  Type 'yes' to continue:

生成菜单的命令行  control not found 问题

D:\Apache24\htdocs\Php_WorkSpace\MfastAdmin>php think menu -c wifi/clock/recordo
rd
controller not found

D:\Apache24\htdocs\Php_WorkSpace\MfastAdmin>php think menu -c wifi/clock/record
Build Successed!


在自动生成的模板当中有这样一句话 application/admin/library/traits/Backend.php   赶快去复制粘贴增删改查的方法吧~
切记多看文档  你会发现新大陆

/**
 * 默认生成的控制器所继承的父类中有index/add/edit/del/multi五个基础方法、destroy/restore/recyclebin三个回收站方法
 * 因此在当前控制器中可不用编写增删改查的代码,除非需要自己控制这部分逻辑
 * 需要将application/admin/library/traits/Backend.php中对应的方法复制到当前控制器,然后进行修改
 */


 在API目录下面  这些接口都已经帮你完成过了  是不是很感动
 
    /**
     * 检测邮箱验证码
     * 
     * @param string $email     邮箱
     * @param string $captcha   验证码
     * @param string $event     事件
     */
    public function check_ems_correct()
    {
        $email = $this->request->request('email');
        $captcha = $this->request->request('captcha');
        $event = $this->request->request('event');
        if (!\app\common\library\Ems::check($email, $captcha, $event))
        {
            $this->error(__('验证码不正确'));
        }
        $this->success();
    }
 
 在非APi目录下这样写
 return json(array("result" => 200, "msg" => "打卡成功", "datas" => ["list" => array()]));
 
 自动生成API文档
 //一键生成API文档
php think api --force=true
问题
Please make sure opcache already enabled, Get help:https://forum.fastadmin.net/d/1321
解决
https://www.cnblogs.com/HD/p/4554455.html