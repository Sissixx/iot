<?php
namespace app\common\model;

use think\Model;
use think\model\concern\SoftDelete;


class Supplier extends Model
{

    //软删除
    use SoftDelete;
    //关联设备表
    public function devices()
    {
        return $this->hasMany('Device','device_id','supplier_id');
    }

    public function add($data)
    {
        $validate = new \app\common\validate\Supplier();
        if (!$validate->scene('add')->check($data)) {
            return $validate->getError();
        }
        //手机和电话不能都为空
        if($data['contact_tel']==null && $data['contact_phone']==null){
            return "手机和电话不能都为空！";
        }
        //判断是否存在
        $name_exits = $this->where('supplier_name',$data['supplier_name'])->find(); //查看用户名是否已经存在
        if($name_exits){
            return "供应商已经存在！";
        }
        //进行保存 并判断是否成功
        if($this->allowField(true)->save($data)){
            return 1;
        }else{
            return "供应商添加失败！";
        }
    }
    public function edit($data)
    {
        $validate = new \app\common\validate\Supplier();
        if (!$validate->scene('edit')->check($data)) {
            return $validate->getError();
        }
        $supplierInfo = $this->where('supplier_id', $data['supplier_id'])->find();
        $tel_exits = $this->where('supplier_name',$data['supplier_name'])->find(); //查看手机号是否已经存在
        if($tel_exits and ($tel_exits['supplier_name'] != $supplierInfo['supplier_name'])){
            return "供应商已经存在！";
        }
//        $supplierInfo = $this->where('supplier_id',$data['supplier_id'])->select();
        $supplierInfo->supplier_name = $data['supplier_name'];
        $supplierInfo->contact_name= $data['contact_name'];
        $supplierInfo->contact_email= $data['contact_email'];
        $supplierInfo->contact_phone= $data['contact_phone'];
        $supplierInfo->contact_tel = $data['contact_tel'];
        //更新并判断是否成功
        if($supplierInfo->allowField(true)->save($data)){
            return 1;
        }else{
            return "供应商信息修改失败！";
        }
    }

    //删
    public function del($data)
    {
        $adminInfo = $this->where('supplier_id',$data['supplier_id'])->find();
        //开始事务
        $this->startTrans();
        try{
            $adminInfo->together('devices')->delete();
            //执行事务
            $this->commit();
            return 1;
        }catch (\Exception $e){
            //事务回滚
            $this->rollback();
            return "供应商删除失败！";
        }
    }
}