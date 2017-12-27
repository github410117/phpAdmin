<?php

namespace app\api\controller\v1;

use app\api\controller\Api;
use app\api\controller\Send;
use app\api\model\Oauth;
use app\api\controller\Oauth as OauthC;
use app\api\model\AdminUser;
use think\Controller;
use think\Exception;
use think\Request;

class Register extends Api
{

    use Send;
    public $apiAuth = false;
    public $restMethodList = 'post';

    //手机客户端请求验证规则
    public static $rule_mobile = [
        'app_key' => 'require',
        'phone' => 'require|length:11',
        'password' => 'require',
        'captcha' => 'require|number'   //手机验证码
    ];

    /**
     * 注册账号
     *
     * @param  \think\Request $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        $requestParam = $this->request->param();
        //检查参数是否传正确
        $result = $this->validate($requestParam, self::$rule_mobile);
        if (true !== $result) {
            return $this->sendError($this->paramErrCode, $result);
        }

        //验证appkey
        $res = Oauth::get(['app_key' => $requestParam['app_key']]);
        if (empty($res)) {
            return $this->sendError($this->paramErrCode, 'appkey错误');
        }

        //验证验证码
        if ($requestParam['captcha'] != '123') {
            return $this->sendError($this->paramErrCode, '验证码不正确');
        }

        //查看是否已注册
        $isregister = model('AdminUser')->queryUser($requestParam['phone']);
        if (!empty($isregister)) {
            return $this->sendError($this->paramErrCode, '该手机号已经注册');
        }

        //删掉appkey和验证码字段
        unset($requestParam['app_key']);
        unset($requestParam['captcha']);

        //生成token
        $token = $this->setAccessToken($requestParam);

        //合并token和用户信息
        $mergeInfo = array_merge($requestParam, $token);

        //写入数据库
        try {
            $addresult = model('AdminUser')->addUser($mergeInfo);
            if (empty($addresult)) {
                return $this->sendError($this->errorCode,'注册失败');
            }
            return $this->sendSuccess($token, '恭喜您注册成功');
        }catch (\Exception $e) {
            return $this->sendError($this->errorCode,$e->getMessage());
        }

    }


    /**
     * 设置AccessToken
     * @param $clientInfo
     * @return int
     */
    protected function setAccessToken($clientInfo)
    {
        //生成令牌
        $accessToken = self::buildAccessToken();
        $accessTokenInfo = [
            'access_token' => $accessToken,//访问令牌
            'expires_time' => time() + OauthC::$expires,      //过期时间时间戳
//            'client' => $clientInfo,//用户信息
        ];
//        self::saveAccessToken($accessToken, $accessTokenInfo);
        return $accessTokenInfo;
    }

    /**
     * 生成AccessToken
     * @return string
     */
    protected static function buildAccessToken($lenght = 32)
    {
        //生成AccessToken
        $str = md5(uniqid(md5(microtime(true)), true));  //生成一个不会重复的字符串
        $str = sha1($str);  //加密
        return $str;
    }
}
