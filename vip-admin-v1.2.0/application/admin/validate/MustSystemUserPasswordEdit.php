<?php
namespace app\admin\validate;
use think\Validate;

/**
 * 修改用户修改密码数据数据验证
 * Class AddSystemUser
 * @package app\admin\validate
 */
class MustSystemUserPasswordEdit extends Validate
{
    protected $rule = [
        'old_password'  => 'require',
        'password'      => 'require|confirm:rep_password',
        'rep_password'  => 'confirm:password'
    ];

    protected $message = [
        'old_password.require'  => '请输入原始密码',
        'password.require'      => '请输入新密码',
        'password.confirm'      => '两次输入密码不一致',
        'rep_password.confirm'  => '两次输入密码不一致'
    ];
}