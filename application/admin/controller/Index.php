<?php
/**
 * Created by PhpStorm.
 * User: chenwenliang
 * Date: 2018/8/7
 * Time: 22:59
 */

namespace app\admin\controller;
use think\Controller;

/**
 * @title 测试登录
 * @description 接口说明
 * @group 接口分组
 * @header name:key require:1 default:1 other: desc:秘钥(区别设置)
 */

class Index extends Controller
{

    //重复登录过滤
    public function initialize()
    {
        if(session('?admin.id')){
            $this->redirect('admin/admin/index');
        }
    }

    /*
     * 测试
     */
    public function test(){
//        $this->view->engine->layout('public/base');
        return $this->fetch('test');
    }
    /* 如果是普通的访问直接显示login页面
     * 登录校验，如果点击登录且是ajax请求是进行校验
     * 验证成功进行跳转
     */

    /**
     * @title 登录接口
     * @description 接口说明
     * @author 开发者
     * @url admin/index/login
     * @method GET|POST

     * @param name:admin_name type:varchar require:1  other: desc:用户名
     * @param name:admin_password type:varchar require:1  other: desc:密码
     *·
     */

    public function login(){
        //判断是否是post请求
//        request()->token();
//        dump($_SESSION);
        try{
            if(request()->isPost()){
                //清除上一个用户留来的session
                session(null);

                //获取数据
                $data = [
                    'admin_name' => input('post.username'),
                    'admin_password' => input('post.password'),
                    '__token__'     => input('post.__token__'),
                ];
                $result = model('Admin')->login($data);

                if($result == 1){
                    return response_tpl('200','登录成功！');
//                    return $this->success('200','登录成功！','admin/admin/index');
                }else{

                    //返回错误信息
                    return response_tpl('400',$result);
//                    return  $this->error('400',$result);
                }
            }
            return view();
        }catch (\Exception $e){
            return_exception($e);
        }

    }
}