<?php
namespace app\admin\validate;
use think\Validate;

/**
 * 修改用户数据数据验证
 * Class AddSystemUser
 * @package app\admin\validate
 */
class MustSystemUserEdit extends Validate
{
    protected $rule = [
        'id'        => 'require',
        'account'   => 'require',
        'gid'       => 'require'
    ];

    protected $message = [
        'id.require'        => '必要数据缺失',
        'account.require'   => '请输入系统账号',
        'gid.require'       => '请输入所属权限组'
    ];
}