<?php

namespace app\admin\model;

use think\Model;

class WifiClockRecord extends Model
{
    // 表名
    protected $name = 'wifi_clock_record';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = false;
    
    // 追加属性
    protected $append = [

    ];
    

    







}
