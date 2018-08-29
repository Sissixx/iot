<?php
/**
 * Created by PhpStorm.
 * User: chenwenliang
 * Date: 2018/8/7
 * Time: 22:35
 */
namespace app\admin\controller;

use function PHPSTORM_META\map;
use think\Error;
use think\Exception;

/**
 * @title 测试用户管理
 * @description 接口说明
 * @group 接口分组
 * @header name:key require:1 default: desc:秘钥(区别设置)
 */

class Admin extends Base
{

    /**
     * @title 个人资料接口
     * @description 接口说明
     * @author 开发者
     * @url admin/admin/profile
     * @method GET
     *
     * @return admin_name:登入账号
     * @return admin_nickname:用户昵称
     * @return admin_role:所属角色
     * @return admin_telephone:手机
     * @return admin_email:邮箱
     * @return admin_status:状态
     *·
     */


    //测试用的

    // public function index(){
    //  return $this->display('test');
    //  }


    //个人信息
    public function profile(){
        $admin_name  = session('admin.name');
        $adminInfo = model('Admin')->where('admin_name', $admin_name)->find();
        if(!$admin_name){
            return "身份信息已经过期!";
        }
        $viewData = [
            'adminInfo' => $adminInfo,
        ];
        $this->assign($viewData);
        return view();
    }






    /**
     * @title 添加接口
     * @description 接口说明
     * @author 开发者
     * @url admin/admin/add
     * @method GET|POST

     * @param name:admin_name type:varchar require:1 other: desc:用户名
     * @param name:admin_nickname type:varchar require:1  other: desc:昵称
     * @param name:admin_password type:varchar require:1  other: desc:密码
     * @param name:admin_com_password type:varchar require:1  other: desc:确认密码
     * @param name:admin_telephone type:char require:1 other: desc:手机
     * @param name:admin_email type:varchar require:1 other: desc:邮箱
     * @param name:admin_role type:enum require:1 default:0 other: desc:权限
     * @param name:admin_status type:enum require:1 default:1 other: desc:状态
     *
     * @return admin_name:登入账号
     * @return admin_nickname:用户昵称
     * @return admin_password:密码
     * @return admin_com_password:确认密码
     * @return admin_telephone:手机
     * @return admin_email:邮箱
     * @return admin_role:所属角色
     * @return admin_status:状态
     *·
     */
    /*
     * 增
     */
    public function add()
    {
        try{
            if(request()->isAjax())
            {
                $data = [
                    'admin_name'            => input('post.admin_name'),        // 管理员账号
                    'admin_password'        => input('post.admin_password'),    //密码
                    'con_password'          => input('post.con_password'),//确认密码
                    'admin_nickname'        => input('post.admin_nickname'),    //昵称
                    'admin_telephone'       => input('post.admin_telephone'),   //电话
                    'admin_email'           => input('post.admin_email'),       //邮箱
                    'admin_status'          => input('post.admin_status'),      //状态
                    'admin_role'            => input('post.admin_role')         //角色
                ];
//            dump($data);
                //进入模型进行插入操作
                $result = model('Admin')->add($data);
                if($result == 1){
                    return response_tpl('200','创建管理员成功');
                }else{
                    return response_tpl('400',$result);
                }
            }
            return view();
        }catch (\Exception $e){
            return_exception($e);
        }

    }


    /**
     * @title 删除接口
     * @description 接口说明
     * @author 开发者
     * @url admin/admin/del
     * @method GET|POST

     * @param name:admin_id type:varchar require:1 other: desc:用户号
     *
     * @return admin_name:登入账号
     * @return admin_nickname:用户昵称
     * @return admin_telephone:手机
     * @return admin_email:邮箱
     * @return admin_role:所属角色
     * @return admin_status:状态
     *·
     */

    /*
     * 删
     */
    public function del()
    {
        try{
            //超级管理员才有删除其他管理员的权利
            if(session('admin.role') == 1){
                $data = [
                    'admin_id' => input('id'),
                ];
                //调用模型使用软删除
                $result = model('Admin')->del($data);
                if($result){
                    //删除成功
                    return response_tpl('200','删除成功!');
                }else{  //失败
                    return response_tpl('400',$result);
                }
            }
            else{
                //权限不足
                return response_tpl('302','权限不足!');
            }
        }
        catch (\Exception $e){
            return $this->error('403',$e);
        }

    }


    /**
     * @title 修改接口
     * @description 接口说明
     * @author 开发者
     * @url admin/admin/edit
     * @method GET|POST

     * @param name:admin_nickname type:varchar require:1  other: desc:昵称
     * @param name:admin_telephone type:char require:1 other: desc:手机
     * @param name:admin_email type:varchar require:1 other: desc:邮箱
     * @param name:admin_role type:enum require:1 default:0 other: desc:权限
     * @param name:admin_status type:enum require:1 default:1 other: desc:状态
     *
     * @return admin_nickname:用户昵称
     * @return admin_telephone:手机
     * @return admin_email:邮箱
     * @return admin_role:所属角色
     * @return admin_status:状态
     *·
     */

    /*
     * 改
     */
    public function edit(){
        try{
            //是超级管理员或者是修改自己的时候才允许操作
            if(session('admin.role') == 1 || (session('admin.id') == input('admin_id'))) {
                if (request()->isAjax()) {
                    //获取修改的数据
                    $data = [
                        'admin_id'         => input('post.admin_id'),                        //被修改的管理员id
                        'admin_telephone' => input('post.admin_telephone'),    //手机号
                        'admin_nickname'  => input('post.admin_nickname'),      //昵称
                        'admin_email'     => input('post.admin_email')              //邮箱
                    ];
                    //如果是超级管理员 data增加role和status数据
                    if (session('admin.role') == 1) {
                        $data_new = ([
                            'admin_role' => input('post.admin_role'),     //角色
                            'admin_status' => input('post.admin_status')  //状态
                        ]);
                        //数据拼接
                        $data = array_merge($data, $data_new);
                    }
                    //进入模型更新数据
                    $result = model('Admin')->edit($data);
                    //成功
                    if ($result == 1) {
                        return response_tpl('200','修改成功');
                    } else {  //失败
                        return response_tpl('400',$result);
                    }
                }
            }else{
                //权限不足
                return response_tpl('403','权限不足!');
            }

            //查询数据用于显示
            $adminInfo = model('Admin')->where('admin_id',input('admin_id'))->find();
//        dump($adminInfo);
            $viewData = [
                'adminInfo' => $adminInfo,
            ];
            $this->assign($viewData);
            return $this->fetch('admin/profile');
        }
        catch (\Exception $e){
            return return_exception($e);
        }
    }

    /*
     * 修改密码
     */
    public function changePassword(){
        try{
            //是超级管理员或者是修改自己的时候才允许操作
            if((session('admin.role') == 1) || (session('admin.id') == input('id'))){
                if (request()->isAjax()){
                    $data = [
                        'admin_id'     =>  input('post.admin_id'),     //被修改的管理员id
                        'own_password' => input('post.own_password'),   //自己的密码
                        'new_password' => input('post.new_password'),   //新密码
                        'con_password' => input('post.con_password'),   //确认密码
                    ];
                    $result = model('Admin')->changePassword($data);
                    if ($result == 1) {
                        return response_tpl('200','修改成功');
                    } else {  //失败
                        return response_tpl('200',$result);
                    }
                }
            }else{
                //权限不足
                return response_tpl('403','权限不足!');
            }
        }
        catch (\Exception $e){
            return_exception($e);
        }

     }

    /**
     * @title 查询接口
     * @description 接口说明
     * @author 开发者
     * @url admin/admin/index
     * @method GET|POST

     * @param name:admin_name type:varchar require:1 other: desc:用户名
     * @param name:admin_nickname type:varchar require:1  other: desc:昵称
     * @param name:admin_role type:enum require:1 default:0 other: desc:权限
     * @param name:admin_telephone type:char require:1 other: desc:手机
     * @param name:admin_email type:varchar require:1 other: desc:邮箱
     * @param name:admin_status type:enum require:1 default:1 other: desc:状态
     *
     * @return admin_name:登入账号
     * @return admin_nickname:用户昵称
     * @return admin_role:所属角色
     * @return admin_telephone:手机
     * @return admin_email:邮箱
     * @return admin_status:状态
     *·
     */


    //查
    public function index(){
        try{

            //获取查询条件
            $maps = [];
            //$maps = map($maps);
            //如果有查询，获取查询条件

            if($condition){
                $map1 = ['admin_name', 'like', '%'.$condition.'%'];
                $map2 = ['admin_nickname', 'like', '%'.$condition.'%'];
                $map3 = ['admin_email', 'like', '%'.$condition.'%'];
                $map4 = ['admin_telephone', 'like', '%'.$condition.'%'];
                $maps = [$map1, $map2, $map3, $map4];
            }
//            fun(){
//
//            };
            //查询排序规则
            $order_rule = [
                'admin_role'    => 'asc',   //角色升序
                'admin_status'  => 'asc'    //状态升序
            ];
            //执行查询
            $queryInfo = model('Admin')->whereOr($maps)
                ->order($order_rule)->paginate(10);
            $sum = $queryInfo->total();
            //返回数据
            $adminInfo = [
                'count'     => $sum,
                'adminInfo' => $queryInfo,
            ];
            $this->assign($adminInfo);
            return view();
//            return $this->fetch('index');
//            return view('index');
        }catch (\Exception $e){
            return return_exception($e);
        }
    }
}