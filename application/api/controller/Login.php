<?php
/**
 * Created by PhpStorm.
 * User: xh
 * Date: 2017/12/26
 * Time: 15:27
 */
namespace app\api\controller;

use think\Controller;
use think\Request;

class Login extends Controller {

    public function index(){
        return '123';
    }

    public function save(){
        $param = input('post.');
        $lowerparam = array_change_key_case($param, CASE_LOWER);
        $res = model('AdminUser')->get(['username' => $lowerparam['username']]);
        return Request::instance()->ext();
    }

}