<?php
/**
 * Created by PhpStorm.
 * User: chenwenliang
 * Date: 2018/8/8
 * Time: 9:03
 */

namespace app\common\model;


use think\Exception;
use think\Model;
use think\model\concern\SoftDelete;

class Admin extends Model
{
    //使用软删除
    use SoftDelete;
    /*
     * 登录验证
     */
    public function login($data){
        //进行场景校验
        $validate = new \app\common\validate\Admin();
        //校验失败返回
        if(!$validate->scene('login')->check($data)){
            return $validate->getError();
        }else{
            //查询对应的用户名
          $result = $this->where('admin_name',$data['admin_name'])->find();
                        //没该用户
                        if(!$result){
                            return '账号不存在！';
                        }else{
                            //密码错误
                            if($result['admin_password'] != $data['admin_password']){
                                return '密码错误！';
                            }
                            else{
                                //被禁用
                                if($result['admin_status'] == 0){
                                    return '该用户被禁用！';
                                }
                                else{
                                    //验证成功，记录用户信息
                        $sessionData = [
                            'id'        =>  $result['admin_id'],
                            'name'      =>  $result['admin_name'],
                            'nickname'  =>  $result['admin_nickname'],
                            'role'      =>  $result['admin_role'],
                        ];
                        session('admin',$sessionData);
                        return 1;
                    }
                }
            }
        }
    }

    /*
     * 添加验证
     */
    public function add($data){

        //场景验证
        $validate = new \app\common\validate\Admin();
        if(!$validate->scene('add')->check($data)){
            return $validate->getError();
        }
        //判断用户名、邮箱、电话是否存在
        $name_exits = $this->where('admin_name',$data['admin_name'])->find(); //查看用户名是否已经存在
        if($name_exits){
            return "用户名已经存在！";
        }
        $tel_exits = $this->where('admin_telephone',$data['admin_telephone'])->find(); //查看手机号是否已经存在
        if($tel_exits && $data['admin_telephone']!= null){
            return "电话已经存在！";
        }
        $email_exits = $this->where('admin_email',$data['admin_email'])->find(); //查看邮箱是否已经存在
        if($email_exits){
            return "邮箱已经存在！";
        }
        //保存平判断是否成功
        if($this->allowField(true)->save($data)){
            return 1;
        }else{
            return "管理员创建失败!";
        }
    }


    /*
     * 删除指定管理员
     */
    public function del($data){
        //先查询后删除
        $adminInfo = $this->where('admin_id','in',$data['admin_id'])->find();
        //删除并判断是否成功
        if($adminInfo->delete()){
            return 1;
        }else{
            return "删除失败！";
        }
    }

    /*
     * 编辑(修改)指定的管理员的信息
     */
    public function edit($data){
        //校验器校验
        $validate = new \app\common\validate\Admin();
        if(!$validate->scene('edit')->check($data)){
            return $validate->getError();
        }
        //查询数据库数据
        $adminInfo = $this->where('admin_id',$data['admin_id'])->find();
        //判断邮箱、电话是否存在
        //查询是否存在相同的手机号，与原本手机号相同时跳过
        $tel_exits = $this->where('admin_telephone',$data['admin_telephone'])->find(); //查看手机号是否已经存在
        if($tel_exits and ($tel_exits['admin_telephone'] != $adminInfo['admin_telephone'])){
            return "手机号已经存在！";
        }
        //查询是否存在相同的邮箱，与原本邮箱相同时跳过
        $email_exits = $this->where('admin_email',$data['admin_email'])->find(); //查看邮箱是否已经存在
        if($email_exits and ($email_exits['admin_email'] != $adminInfo['admin_email'])){
            return "邮箱已经存在！";
        }
        //更新数据
        $adminInfo->admin_nickname = $data['admin_nickname'];
        $adminInfo->admin_telephone = $data['admin_telephone'];
        $adminInfo->admin_email    = $data['admin_email'];
        if(session('admin.role') == 1){
            $adminInfo->admin_role   = $data['admin_role'];
            $adminInfo->admin_status    = $data['admin_status'];
        }
        //保存并判断是否成功
        if($adminInfo->save()){
            return 1;
        }else{
            return "修改失败(请检查信息是否有更新！)";
        }
    }

    /*
     * 修改密码
     */
    public function changePassword($data){
        /*
         * 所以要先确认自己的密码是否正确
         * 才能进一步修改
         */
        $rightPass = $this->where('admin_name', session('admin.name'))->
                    where('admin_password', $data['own_password'])->find();
        if(!$rightPass){
            return "自身密码错误！";
        }
        //数据校验
        $validate = new \app\common\validate\Admin();
        if(!$validate->scene('changePassword')->check($data)){
            return $validate->getError();
        }
        //查询获得要修改的数据
        $adminInfo = $this->where('admin_id', $data['admin_id'])->find();
        //更新密码
        $adminInfo->admin_password = $data['new_password'];

        //保存并判断是否成功
        if( $adminInfo->save()){
            return 1;
        }else{
            return "修改失败";
        }
    }
}