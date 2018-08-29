<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------
// 应用公共文件

//把span字符串替换成a
function replace($data)
{
    return str_replace('span', 'a', $data);
}
//模糊查询函数
function map($maps){
    $condition = input('keywords');
    if($condition ){
        $map1 = ['supplier_name', 'like', '%'.$condition.'%'];
        $map2 = ['supplier_id', 'like', '%'.$condition.'%'];
        $map3 = ['contact_name', 'like', '%'.$condition.'%'];
        $maps = [$map1, $map2, $map3];
    }
    elseif($condition){
        $map1 = ['admin_name', 'like', '%'.$condition.'%'];
        $map2 = ['admin_nickname', 'like', '%'.$condition.'%'];
        $map3 = ['admin_email', 'like', '%'.$condition.'%'];
        $map4 = ['admin_telephone', 'like', '%'.$condition.'%'];
        $maps = [$map1, $map2, $map3, $map4];
    }
    return $maps;
}

//记录系统日志
/*
 * param cause 记录发生错误原因
 */
function recored_system_log($cause){
    if(!$cause){
        return;
    }
    trace('['.date('Y-m-d H:i:s').']'.'['.$cause.']', 'my_error');
}

/*
 * @param e [Exception] 系统异常对象
 * @param path [String] 发生错误的程序方法
 * @param selfdefine_exp_msg [String] 异常错误信息
 * @return [Array]
 */
function return_exception($e, $selfdefine_exp_msg=null, $datas = null){
    if( $selfdefine_exp_msg!=null ){
        $exp_msg = $selfdefine_exp_msg;
    }else{
        $exp_msg = '[文件:'.$e->getFile().'][行数:'.$e->getLine().'][信息:'.$e->getMessage().']';
    }
    //如果为运营阶段，异常会写入日志文件
    if( config('IS_SHOW_SYSTEM_EXP') === false ){
        recored_system_log($exp_msg);
    }
    return array(
        'res_code'  =>  500,
        'msg'       =>  '系统异常',
        'exp_msg'   =>  (config('IS_SHOW_SYSTEM_EXP') ? $exp_msg : '查看详细异常信息请到配置文件开启权限'),
        'datas'     =>  $datas
    );
}

/*
 * 返回数据模板
 * @param res_code 返回的code值
 * @param msg 返回的信息
 * @param url 路径
 * @param datas 其他内容
 * @return [Array]
 */
function response_tpl($code, $msg, $url = null, $datas=null){
    return array(
        'code'      =>  $code,
        'msg'       =>  $msg,
        'datas'     =>  $datas,
        'url'       =>  $url,
    );
}




function chaxun(          )
{


}

