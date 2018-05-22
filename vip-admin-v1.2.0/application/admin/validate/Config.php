<?php
namespace app\admin\validate;
use think\Validate;

/**
 * 后台配置验证
 * Class Config
 * @package app\admin\validate
 */
class Config extends Validate
{
    protected $rule = [
        'title'     => 'require',
        'version'   => 'require',
        'copy'      => 'require',
        'icp'       => 'require',
        'code'      => 'require'
    ];

    protected $message = [
        'title.require'     => '请输入软件名称',
        'version.require'   => '请输入版本号',
        'copy.require'      => '请输入版权信息',
        'icp.require'       => '请输入ICP备案号',
        'code.require'      => '请输入统计代码'
    ];
}