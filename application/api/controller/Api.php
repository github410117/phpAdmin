<?php
/**
 * Created by PhpStorm.
 * User: xh
 * Date: 2017/12/26
 * Time: 16:46
 */

namespace app\api\controller;


use think\Controller;
use think\Request;

class Api extends Controller
{
    use Send;

    /**
     * 对应操作
     * @var array
     */
    public $methodToAction = [
        'get'       => 'read',
        'post'      => 'save',
        'put'       => 'update',
        'delete'    => 'delete',
        'patch'     => 'patch',
        'head'      => 'head',
        'options'   => 'options',
    ];

    /**
     * 允许访问的请求类型
     * @var string
     */
    public $restMethodList = 'get|post|put|delete|patch|head|options';

    /**
     * 是否验证,默认不验证
     * @var bool
     */
    public $apiAuth = false;

    protected $request;

    /**
     * 当前请求类型
     * @var string
     */
    protected $method;

    /**
     * 当前资源类型
     * @var string
     */
    protected $type;

    public static $app;

    /**
     * 返回的资源类型
     * @var string
     */
    protected $restTypeList = 'json';

    /**
     * RESTful允许输出的资源类型列表
     * @var array
     */
    protected $restOutputType = [
        'json' => 'application/json',
    ];

    /**
     * 客户端信息
     */
    protected $clientInfo;


    /**
     * 控制器初始化操作
     */
    public function _initialize()
    {
        $this->request = Request::instance();
        $this->init();//检查资源类型
        $this->clientInfo = $this->checkAuth();//接口权限检查
    }

    /**
     * 初始化方法
     * 检测请求类型,数据格式等操作
     */
    public function init(){

        //资源类型检测
        $request = Request::instance();
        $ext = $request->ext();

        if ($ext == '') {
            $this->type = $request->type();//自动检测资源类型
        }elseif (!preg_match('/\(' . $this->restTypeList . '\)$/i', $ext)) {//资源类型非法,这里的list写的只有个json类型,应该还可以添加
            $this->type = $this->restDefaultType;//如果是非法的,就用默认的资源类型访问
        }else {
            $this->type = $ext;//如果不是非法的,就是html后缀等
        }

        $this->setType();

        //请求方式检测,将其转换为全大写
        $method = strtolower($request->method());
        $this->method = $method;

        if (stripos($this->restMethodList, $method) === false) {//如果没有检测到该方法，返回错误,提示不允许此方法
            return self::returnmsg(405,'不支持该请求方法',[],["Access-Control-Allow-Origin" => $this->restMethodList]);
        }
    }

    /**
     * 检测客户端是否有权限调用接口
     */
    public function checkAuth() {

    }

    /**
     * 空操作,遇到没有定义的方法,会走这里
     * @return \think\Response|\think\response\Json|\think\response\Jsonp|\think\response\Redirect|\think\response\View|\think\response\Xml
     */
    public function _empyt() {
        return $this->sendSuccess([],'该方法没有定义',200);
    }

}