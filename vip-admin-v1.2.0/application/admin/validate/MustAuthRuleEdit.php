<?php
namespace app\admin\validate;
use think\Validate;

/**
 * 添加菜单数据验证
 * Class AddSystemUser
 * @package app\admin\validate
 */
class MustAuthRuleEdit extends Validate
{
    protected $rule = [
        'id'        => 'require',
        'name'      => 'require|unique:MustAuthRule',
        'url'       => 'require|unique:MustAuthRule'
    ];

    protected $message = [
        'id.require'    => '数据缺失',
        'name.require'  => '请输入菜单名称',
        'name.unique'   => '菜单名称已存在',
        'url.require'   => '请输入菜单定位',
        'url.unique'    => '菜单定位已存在',
    ];
}