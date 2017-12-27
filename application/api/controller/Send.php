<?php
/**
 * Created by PhpStorm.
 * User: xh
 * Date: 2017/12/26
 * Time: 17:31
 */
namespace app\api\controller;

use think\Response;
use think\response\Redirect;

trait Send {

    /**
     * 默认返回资源类型
     * @var string
     */
    protected $restDefaultType = 'json';

    /**
     * 设置响应类型
     * @param null $type
     * @return $this
     */
    public function setType($type = null) {
        $this->type = (string)(!empty($type)) ? $type : $this->restDefaultType;
        return $this;
    }


    /**
     * 失败的响应
     */
    public function sendError($error = 400, $message = 'error', $code = 200, $data = [], $headers = [], $options = []) {
        return $this->response($this->creatSendResponse($error,$message,$data,$options), $code, $headers);

    }



    /**
     * 成功响应
     */
    public function sendSuccess($data = [], $message = 'success', $code = 200, $headers = [], $options = []) {
        return $this->response($this->creatSendResponse(0,$message,$data,$options), $code, $headers);
    }

    /**
     * 封装响应方法
     * @param int $error
     * @param string $message
     * @param array $data
     * @param array $options
     * @return array
     */
    private function creatSendResponse($error = 0, $message = 'success', $data = [], $options = []) {
        $responseData['status'] = (int)$error;
        $responseData['message'] = (string)$message;
        if (!empty($data)) $responseData['data'] = $data;
        $responseData = array_merge($responseData, $options);
        return $responseData;
    }

    /**
     * 重定向
     * @param $url
     * @param array $params
     * @param int $code
     * @param array $with
     * @return Redirect
     */
    public function sendRedirect($url, $params = [], $code = 302, $with = []) {
        $response = new Redirect($url);
        if (is_integer($params)) {
            $code = $params;
            $params = [];
        }
        //TODO:这一块不懂
        $response->code($code)->params($params)->with($with);
        return $response;
    }

    /**
     * 响应
     * @param $responseData
     * @param $code
     * @param $headers
     * @return Response|\think\response\Json|\think\response\Jsonp|Redirect|\think\response\View|\think\response\Xml
     */
    public function response($responseData, $code, $headers) {
        //isset是表示如果设置了type
        if (!isset($this->type) || empty($this->type)) $this->setType();
        return Response::create($responseData, $this->type, $code, $headers);
    }

    /**
     * 如果需要允许跨域请求，请在记录处理跨域options请求问题，并且返回200，以便后续请求，这里需要返回几个头部。。
     * @param string $code
     * @param string $message
     * @param array $data
     * @param array $header
     */
    public function returnmsg($code = '400', $message = '', $data = [], $header = []) {
        http_response_code($code);
        $return['status'] = $code;
        $return['message'] = $message;
        if (!empty($data)) $return['data'] = $data;

        //发送头部信息
        foreach ($header as $name => $val) {
            if (is_null($val)) {
                header($name);
            }else {
                header($name . ':' .$val);
            }
        }
        exit(json_encode($return,JSON_UNESCAPED_UNICODE));
    }


}