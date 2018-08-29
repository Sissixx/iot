<?php

namespace app\admin\controller;

use think\Db;

/**
 * @title 测试设备管理
 * @description 接口说明
 * @group 接口分组


 */
class Device extends Base
{

    //监听数据库
    protected function listenSql(){
        Db::listen(function ($sql, $time, $explain) {
// 记录SQL
            echo $sql . ' [' . $time . 's]';
// 查看性能分析结果
            dump($explain);
        });
    }




    /**
     * @title 添加接口
     * @description 接口说明
     * @author 开发者
     * @url /admin/device/
     * @method GET|POST


     * @param name:device_name type:string require:1 default: other: desc:设备名称
     *@param name:device_location type:string require:1 default: other: desc:设备所在地
     * @param name:device_status type:enum require:1 default:在线 other: desc:设备状态
     * @param name:device_agreement type:string require: default: other: desc:设备协议
     * @param name:supplier_name type:int require:1 default: other:与供应商表关联 desc:供应商名称
     *
     * @return device_id:设备ID
     * @return device_name:设备名称
     * @return device_location:设备所在地
     * @return device_status:设备状态
     * @return device_agreement:设备协议
     * @return supplier_name:供应商名称
     * @return create_time:添加时间
     *
     */
//    添加设备
    public function add()
    {
        try{
            if (request()->isPost()) {
                //获取设备信息
                $data = [
                    'device_name'       => input('post.device_name'),        //设备名称
                    'device_location'   => input('post.device_location'),   //设备位置
                    'device_agreement'  => input('post.device_agreement'),  //协议
                    'device_status'     => input('post.device_status'),     //状态
                    'supplier_id'       => input('post.supplier_id')        //设备商ID
                ];
                //使用模型进行数据添加
                $result = model('Device')->add($data);
                if ($result == 1) {
    //                成功
                    return response_tpl('200','设备信息添加成功');
//                    $this->success('200','设备信息添加成功','admin/device/index');
                } else {
                    return response_tpl('400',$result);
                    //失败
//                    $this->error('400',$result);
                }
            }
            //获得供应商的信息
            $data = model('Supplier')->field('supplier_id,supplier_name')->select();
    //            dump($data);
            $supplierInfo = [
                'supplierInfo' => $data,
            ];
            $this->assign($supplierInfo);
            return view();
            }
        catch (\Exception $e){
            return return_exception($e);
        }
    }



    /**
     * @title 删除接口
     * @description 接口说明
     * @author 开发者
     * @url /admin/device/
     * @method GET|POST

     * @param name:device_id type:int require:1 default:要删除信息的设备ID other: desc:设备ID
     * @param name:device_name type:string require:1 default:与设备ID对应的设备名称 other: desc:设备名称
     *@param name:device_location type:string require:1 default:对应的设备所在地 other: desc:设备所在地
     * @param name:device_status type:enum require:1 default:对应的设备状态 other: desc:设备状态
     * @param name:device_agreement type:string require: default:对应的设备协议 other: desc:设备协议
     * @param name:supplier_name type:int require:1 default:对应的供应商名称 other: desc:供应商名称
     * @return update_time:更新时间
     * @return delete_time:删除时间
     *
     */
    //      删除设备
    public function del()
    {
        try{
            $data = [
                'device_id' => input('id'),     //删除的设备id
            ];
            //调用模型使用软删除，获得返回值
            $result = model("Device")->del($data);

            if ($result == 1) {
//            return "删除成功！";
                return response_tpl('200','设备删除成功!');
            } else {
//            return "删除失败！";
                return response_tpl('400',$result);

            }
        }catch (\Exception $e){
            return_exception($e);
        }

    }

    /**
     * @title 修改接口
     * @description 接口说明
     * @author 开发者
     * @url /admin/device/
     * @method GET|POST

     * @param name:device_name type:string require:1 default:与当前要修改的设备ID对应的设备名称 other:不显示当前设备ID desc:设备名称
     *@param name:device_location type:string require:1 default:对应的设备所在地 other: desc:设备所在地
     * @param name:device_status type:enum require:1 default:对应的设备状态 other: desc:设备状态
     * @param name:device_agreement type:string require: default:对应的设备协议 other: desc:设备协议
     * @param name:supplier_name type:int require:1 default:对应的供应商名称 other:与供应商表关联 desc:供应商名称
     * @return device_id:设备ID
     * @return device_name:设备名称
     * @return device_location:设备所在地
     * @return device_status:设备状态
     * @return device_agreement:设备协议
     * @return supplier_name:供应商名称
     * @return update_time:更新时间
     *
     */
    public function edit()
    {
        try{
            if (request()->isPost()) {
                $data = [
                    'device_id'             =>  input('post.id'),               //设备id
                    'device_name'           => input('post.device_name'),       //名称
                    'device_location'       => input('post.device_location'),   //位置
                    'device_agreement'      => input('post.device_agreement'),  //协议
                    'device_status'         =>  input('post.device_status'),    //状态
                    'supplier_id'           => input('post.supplier_id')        //供应商id
                ];
                //获得模型操作后的返回值
                $result = model('Device')->edit($data);
                if ($result==1) {
                    //成功
                    return response_tpl('200','设备编辑成功！');
//                    $this->success('200','设备编辑成功！', 'admin/device/index');
                } else {
                    //失败
                    return response_tpl('400',$result);
//                    $this->error('400',$result);
                }
            }
            //获得对应的设备id
            $device_id = input('device_id');
            //返回给前台的信息
            $deviceInfo = model('Device')->where('device_id',$device_id)->find();
            //获得供应商的信息
            $supplierInfo = model('Supplier')->field('supplier_id,supplier_name')->select();
            //返回信息数组
            $viewData = [
                'deviceInfo' => $deviceInfo,            //设备信息
                'supplierInfo' => $supplierInfo        //供应商信息
            ];
            $this->assign($viewData);
            return view();
        }catch (\Exception $e){
            return_exception($e);
        }

    }

    /**
     * @title 设备主页接口
     * @description 接口说明
     * @author 开发者
     * @url /admin/device/
     * @method GET|POST


     * @return device_id:设备ID
     * @return device_name:设备名称
     * @return device_location:设备所在地
     * @return device_status:设备状态
     * @return device_agreement:设备协议
     * @return supplier_name:供应商名称
     * @return create_time:添加时间
     *
     */

    //设备管理首页
    public function index()
    {
        try{
            //先查供应商表
            //查询条件
            //  $this->listenSql();
            $condition = input('keywords');
            $maps = [];
            //如果有查询
            if(null != $condition){
                //根据供应商的名称查出对应的supplier_id，在通过id查询对应的设备信息
                $supp = model('Supplier')->where('supplier_name','like','%'.$condition.'%')
                    ->column('supplier_id');
                if ($supp !=null){
                    $map=['supplier_id','in',$supp];
                    $maps=[$map];
                }
                //如果查询的是在线或者是离线，装换成对应的0 1
                elseif(strstr('在线',$condition)){
                    $map = ['device_status', '=', 0];
                    $maps =[$map];
                }
                elseif (strcmp('离线',$condition) == 0){
                    $map = ['device_status', '=', 1];
                    $maps =[$map];
                }
                //其余的便是查询供应商名称、id
                else{
                    //组合查询条件
                    $map1 = ['device_name', 'like', '%'.$condition.'%'];
                    $map2 = ['device_id', 'like', '%'.$condition.'%'];
                    $maps = [$map1, $map2];
                }
            }

            //排序规则
            $rule = [];
            //关联查询供应商表
            $data = model('Device')->with('supplier')
                ->whereOr($maps)
                ->order($rule)->paginate('10');
            //统计总的设备数目
            $sum = $data->total();
            //返回信息
            $viewData = [
                'deviceInfo' => $data,  //设备的基本信息
                'sum'         => $sum,  //总数
            ];
            $this->assign($viewData);
            return view();
        }catch (\Exception $e){
            return return_exception($e);
        }
    }

}
