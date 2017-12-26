<?php
/**
 * Created by PhpStorm.
 * User: xh
 * Date: 2017/12/26
 * Time: 16:36
 */

namespace app\index\controller;


class Error
{
    public function index(){
        return json(array('error' => 405, 'message' => '请求的路径不存在'));
    }

}