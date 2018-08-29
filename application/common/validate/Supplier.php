<?php

namespace app\common\validate;

use think\Validate;

class Supplier extends Validate{

    protected $rule = [
        'supplier_name|供应商名称'       => 'require',
        'contact_name|联系人姓名'        => 'require',
        'contact_tel|联系人电话'         =>  'mobile',
        'contact_phone|电话号'           => ['regex:/[0-9]{11}|[0-9]{4}-[0-9]{7}/'],
        'contact_email|邮箱'             => 'email'
        ];
    //添加场景验证
    public function sceneAdd()
    {
        return $this->only(['supplier_name','contact_name','contact_phone','contact_tel', 'contact_email']);
    }
    //编辑场景验证
    public function sceneEdit()
    {
        return $this->only(['supplier_name','contact_name','contact_phone','contact_tel', 'contact_email']);
    }

}