<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
Route::pattern([
    'id'             => '\d+',
    'video_id'      => '\d+',
     'device_id'    => '\d+',
    'supplier_id'   => '\d+',
    'admin_id'      => '\d+'
]);
Route::rule('/','admin/index/login','get|post');
Route::rule('/test','admin/Demo/index','get|post');
Route::group('admin', function () {
    Route::rule('test', 'admin/index/test', 'get|post');
    Route::rule('login', 'admin/index/login', 'get|post');
    Route::rule('login_out', 'admin/home/loginout', 'get');
    Route::group('user', function () {
        Route::rule('index', 'admin/admin/index', 'get|post');
        Route::rule('profile', 'admin/admin/profile', 'get');
        Route::rule('add', 'admin/admin/add', 'get|post');
        Route::rule('delete', 'admin/admin/del', 'post|get');
        Route::rule('edit/[:admin_id]', 'admin/admin/edit', 'get|post');
        Route::rule('changepasswd', 'admin/admin/changepassword', 'post');
//        Route::rule('query', 'admin/admin/query', 'post|get');
    });
    Route::group('device', function (){
        Route::rule('index', 'admin/device/index','post|get');
        Route::rule('add', 'admin/device/add','post|get');
        Route::rule('edit/[:device_id]', 'admin/device/edit','post|get');
        Route::rule('delete', 'admin/device/del', 'post|get');
    });
    Route::group('supplier', function (){
        Route::rule('index', 'admin/supplier/index');
        Route::rule('edit/[:supplier_id]', 'admin/supplier/edit');
        Route::rule('add', 'admin/supplier/add');
        Route::rule('delete', 'admin/supplier/del');
    });
});
//Route::group('admin', function (){
//    Route::rule('personal_info', 'admin/admin/personalInfo','get');
//    Route::rule('info', 'admin/admin/info','get');
//});
//Route::get('think', function () {
//    return 'hello,ThinkPHP5!';
//});
//
//Route::get('hello/:name', 'index/hello');
//
//return [
//
//];
