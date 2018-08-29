<?php

namespace app\common\validate;

use think\Validate;

class Device extends Validate{

    protected $rule = [
        'device_name|设备名称'           => 'require',    //必须
        'device_location|设备所在地'     => 'require',
        'device_status|设备状态'         => 'require|in:0,1',
        'supplier_id|设备商'             => 'require',
        ];
    protected $message = [
    ];
    //设备添加的场景验证
    public function sceneAdd()
    {
        return $this->only(['device_name','supplier_id', 'device_location']);
    }
    //编辑时的场景验证
    public function sceneEdit()
    {
        return $this->only(['device_name','supplier_id', 'device_location']);
    }

}