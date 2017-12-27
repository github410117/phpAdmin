<?php
/**
 * Created by PhpStorm.
 * User: xh
 * Date: 2017/12/21
 * Time: 17:18
 */
namespace app\api\model;

use think\Model;

class AdminUser extends Model {

    public function addUser($userinfo){
       return $this->insert($userinfo);
    }

    public function queryUser($phone){
        return $this->where('phone',$phone)->find();
    }

}