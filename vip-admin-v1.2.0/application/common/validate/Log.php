<?php
namespace app\common\validate;
use think\Validate;

/**
 * 日志操作验证
 * Class Log
 * @package app\admin\validate
 */
class Log extends Validate
{
    protected $rule = [
        'operation_position'    => 'require',
        'operation_ip'          => 'require',
        'time'                  => 'require',
        'operation_ip_area'     => 'require'
    ];

    protected $message = [
        'operation_position.require'    => '操作位置记录失败',
        'operation_ip.require'          => '操作ip记录失败',
        'operation_ip_area.require'     => 'ip所在地域记录失败',
        'time.require'                  => '操作时间记录失败'
    ];
}