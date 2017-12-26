<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------


use think\Route;

Route::resource('api/infos','api/userinfo');
Route::resource('api/login','api/login');
Route::miss('Error/index');//注册一个错误访问的路由.如果访问的Api没有对应的路径，则返回Error控制器中index的返回值
//Route::get('index','api/index');
//return [
//    '__pattern__' => [
//        'name' => '\w+',
//    ],
//    '[hello]'     => [
//        ':id'   => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
//        ':name' => ['index/hello', ['method' => 'post']],
//    ],
//
//];
http://1855249.ch1.data.tv002.com:443/down/b0453c99ce3986a88a9b0b6322614755-189765328/XMind%208%203.7.6.dmg?cts=f-D27A154A254A18Fba3a8&ctp=27A154A254A18&ctt=1513906786&limit=1&spd=150000&ctk=7ab64af53e6b1f60368b7d1242535b6f&chk=b0453c99ce3986a88a9b0b6322614755-189765328