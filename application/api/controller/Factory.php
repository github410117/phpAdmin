<?php
/**
 * Created by PhpStorm.
 * User: xh
 * Date: 2017/12/26
 * Time: 18:23
 */

namespace app\api\controller;


class Factory
{
    private static $Factory;

    private function __construct(){}

    public static function getInstance($className, $options = null) {
        if (!isset(self::$Factory[$className]) || !self::$Factory[$className]) {
            self::$Factory[$className] = new $className($options);
        }
        return self::$Factory[$className];
    }
}