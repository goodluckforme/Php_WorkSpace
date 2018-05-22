<?php
namespace app\admin\validate;
use think\Validate;

/**
 * 后台添加系统用户验证
 * Class AddSystemUser
 * @package app\admin\validate
 */
class AddSystemUser extends Validate
{
    protected $rule = [
        'account'       => 'require|unique:MustSystemUser',
        'password'      => 'require|confirm:re_password',
        're_password'   => 'confirm:password',
    ];

    protected $message = [
        'account.require'           => '请输入账号',
        'account.unique'            => '用户名已存在',
        'password.require'          => '请输入密码',
        'password.confirm'          => '两次输入密码不一致',
        're_password.confirm'       => '两次输入密码不一致',
    ];
}