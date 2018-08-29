<?php
namespace app\common\model;
use think\Model;
use think\model\concern\SoftDelete;

class Device extends Model
{
    //软删除
    use SoftDelete;

    //关联供应商表
    public function supplier()
    {
        return $this->belongsTo('Supplier', 'supplier_id','supplier_id')
            ->field('supplier_id,supplier_name');
    }
    //增
    public function add($data)
    {
        //校验器校验
        $validate = new \app\common\validate\Device();
        if (!$validate->scene('add')->check($data)) {
            return $validate->getError();
        }
        //数据插入
        if($this->allowField(true)->save($data)){
            return 1;
        }else{
            return "设备添加失败！";
        }
    }

    //删
    public function del($data){
        //查询要删除的数据
        $adminInfo = $this->where('device_id',$data['device_id'])->find();
        //删除并判断是否成功
        if($adminInfo->delete()){
            return 1;
        }
        else{
            return "删除失败！";
        }
    }
    //改
    public function edit($data)
    {
        //校验器校验
        $validate = new \app\common\validate\Device();
        if (!$validate->scene('edit')->check($data)) {
            return $validate->getError();
        }
        //查询获得要修改的数据
        $deviceInfo = $this->where('device_id', $data['device_id'])->find();
//        $deviceInfo = $this->where('device_id',$data['device_id'])->select();
        //更新数据
        $deviceInfo->device_name = $data['device_name'];
        $deviceInfo->device_location= $data['device_location'];
        $deviceInfo->device_agreement= $data['device_agreement'];
        $deviceInfo->device_status= $data['device_status'];
        $deviceInfo->supplier_id = $data['supplier_id'];
        //开始事务
        if($deviceInfo->save()){
            return 1;
        }else{
            return "设备信息更新失败！";
        }
    }
}