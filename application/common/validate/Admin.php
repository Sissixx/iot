<?php
/**
 * 管理员的场景验证
 * Created by PhpStorm.
 * User: chenwenliang
 * Date: 2018/8/8
 * Time: 9:04
 */

namespace app\common\validate;


use think\Validate;

class Admin extends Validate
{
    //验证规则
    protected $rule = [
        'admin_name|管理员账号'   => 'require',
        //没有字符的   必须包含字母和数字
        //'admin_password|密码'     => 'require|/(?=.*[A-Za-z])(?=.*[0-9])[A-Za-z0-9]{8,20}/',
        //必须包含大写字母，小写字母，数字和字符中的两个及以上
        'admin_password|密码'     =>'require|(?![A-Z]+$)(?![a-z]+$)(?!\d+$)(?![\W_]+$)\S{8,}$',
        //必须包含大写字母，小写字母，数字和字符中的三个及以上
        //'admin_password|密码'     =>'require|(?![A-Za-z]+$)(?![A-Z\\d]+$)(?![A-Z\\W]+$)(?![a-z\\d]+$)(?![a-z\\W]+$)(?![\\d\\W]+$)\\S{8,20}$',
        'con_password|确认密码'   => 'require',
        'old_password|原密码'     => 'require',
        'new_password|新密码'     => 'require|/(?=.*[A-Za-z])(?=.*[0-9])[A-Za-z0-9]{8,20}/',
        'admin_nickname|昵称'     => 'require',
        'admin_email|邮箱'        => 'require|email',
        'admin_code|验证码'       => 'require',
        'admin_telephone|手机号'  => 'mobile',
        'admin_role|角色'         => 'in:0,1|require',
        'admin_status|状态'       => 'in:0,1,2|require',
        '__token__|表单令牌'      =>   'token'
    ];
    /*
     * 登录场景验证
     */
    public function sceneLogin (){
        return $this->only(['admin_username', 'admin_password']);
    }

    /*
     * 添加管理员验证
     */
    public function sceneAdd(){
        return $this->only(['admin_name',
                            'admin_password',
                            'con_password',
                            'admin_nickname',
                            'admin_email',
                            'admin_telephone',
                            'admin_role',
                            'admin_status'])
            ->append('con_password','confirm:admin_password');
    }

    /*
     * 修改管理员信息
     */
    public function sceneEdit(){
        if(session('admin.role') == 1){
            return $this->only(['admin_email', 'admin_nickname', 'admin_telephone', 'admin_role' , 'admin_status']);
        }
        return $this->only(['admin_email', 'admin_nickname', 'admin_telephone']);
    }

    /*
     * 修改密码
     */
    public function sceneChangePassword(){
        return $this->only([ 'new_password', 'con_password'])
            ->append('con_password','confirm:new_password');
    }

}