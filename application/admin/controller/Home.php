<?php
/**
 * Created by PhpStorm.
 * User: chenwenliang
 * Date: 2018/8/12
 * Time: 23:10
 * 功能：后台首页
 */

namespace app\admin\controller;


use think\Controller;

class Home extends Controller
{
    //后台首页
    public function index(){
        return view();
    }

    //用户退出
    public function loginOut(){
        //清空session
        session(null);
        //成功返回对应的页面
        if(session('?admin.id')){
           $this->error('退出失败');
           //return response_tpl('400', '退出失败!');
        }else{
            $this->success('200',"退出成功", 'admin/index/login');
          //return response_tpl('200', '退出成功！','admin/index/login');
        }
    }
}