<?php
// +----------------------------------------------------------------------
// | ThinkCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2017 http://www.zheyitianshi.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: Dean <zxxjjforever@163.com>
// +----------------------------------------------------------------------
namespace api\user\controller;

use think\Db;
use think\Validate;
use cmf\controller\RestBaseController;

class MsgController extends RestBaseController
{

	private $appid = '';
    private static $soapClientHandler;
    public $apiurl = 'http://61.130.108.55:53110/services/message?wsdl';
    public $apiurl2 = 'http://61.130.108.55:53110/services/notify?wsdl';
    
    public function _initialize()
    {
        
        $this->appid = '00000000-0000-0000-0000-000000000000';
    }

    public function demo()
    {
        // bulog('test','log',true);
        // throw new \think\Exception('调用sendMessage结果出现异常');
        $client = new \SoapClient('http://61.130.108.55:53110/services/message?wsdl');

        print "\n提供的方法\n";
        dump($client->__getFunctions());
        print "相关的数据结构\n";
        dump($client->__getTypes());
        print "\n\n";

    }

    public function demo2() 
    {

        $client = new \SoapClient('http://61.130.108.55:53110/services/notify?wsdl');

        print "\n提供的方法\n";
        dump($client->__getFunctions());
        print "相关的数据结构\n";
        dump($client->__getTypes());
        print "\n\n";
    }

    /**
     * notify
     * string appId;
     * string type;
     * string dataJson;
     */
    public function notify(){

        try {

            // [createdTime] => 2018-12-15T16:13:54.330
            // [deliveryStatus] => 0
            // [messageId] => 00000000-0000-0000-0000-000000000000
            // [receiveAddress] => *
            // [sendAddress] => *
            // [statusCode] => DELIVRD
            // [statusDescription] => 消息发送成功

            $d = [
                'createdTime' => '2018-12-15T16:13:54.330',
                'deliveryStatus' => 0,
                'messageId' => '00000000-0000-0000-0000-000000000000',
                'receiveAddress' => '*',
                'sendAddress' => '*',
                'statusCode'  => 'DELIVRD',
                'statusDescription' => '消息发送成功'
            ];
            $dataJson = $this->tojson($d);
            // dump($dataJson);
            // die();
            //set request param
            $parameter = array(
                'appId' => $this->appid,
                'type'  => 'DeliveryReport',
                'dataJson' => $dataJson
            );

            $result = $this->getSoapClientHandler()->notify($parameter);
            bulog($result,'log',true);
            // dump($result);
        } catch (SoapFault $soapFault) {
            throw new \think\Exception($soapFault->getMessage() . $this->getSoapClientHandler()->__getLastResponse());
        }
    }

    //发送验证短信接口
    public function send() {

    	$validate = new Validate([
            'mobile' => 'require'
        ]);
        $validate->message([
            'mobile.require' => '请输入手机号'
        ]);

        $data = $this->request->param();
        if (!$validate->check($data)) {
            $this->error($validate->getError());
        }
        $mobile = $data['mobile'];
        if(preg_match("/^1[34578]\d{9}$/", $mobile)){

        	DB::startTrans();
        	//sms表  id mobile code add_time ip
        	$maxcount = 3;
        	$todaytime = strtotime(date("Y-m-d"));
        	$where['mobile'] = $mobile;
        	$where['add_time'] = array('gt',$todaytime);
        	$smsCount = DB::name('sms')->where($where)->count();
        	if($smsCount >= $maxcount) {
        		$this->error('验证码发送频繁,请明天再试');
        	}
        	$code = rand(1000,9999);
        	$addSms = [
        		'mobile' 	=> $mobile,
        		'code' 		=> $code,
        		'add_time' 	=> time(),
        		// 'ip' 		=> getIp()
        	];
        	$smsid = Db::name('sms')->insertGetId($addSms);
        	if($smsid) {
        		$res = $this->toSend($mobile,$code);
        		if($res) {
        			DB::commit();
        			$this->success('发送成功');
        		}else {
        			DB::rollback();
        			$this->error('发送失败');
        		}
        	}

        }else {
        	$this->error('请输入正确的手机格式');
        }
        

    }

    /**
     * sendMessage
     * string appId;
     * array destination;
     * string message;
     */
    public function toSend($mobile,$code) {

    	try {

            //set request param
            $parameter = array(
                'appId' => $this->appid,
                'destination' => $mobile,
                'message' => '本次四书的验证码是：'.$code
            );

            $result = $this->getSoapClientHandler()->sendMessage($parameter);
            // bulog($result,'log',true);

            if(empty($result->return) || $result->return == null) {
            	return false;
            }
            return true;

            //调用结果返回异常
            if (!$result instanceof stdClass) {
                throw new \think\Exception("调用异常:" . json_encode($result));
            }

            
        } catch (SoapFault $soapFault) {
            throw new \think\Exception($soapFault->getMessage() . $this->getSoapClientHandler()->__getLastResponse());
        }
    }

    //查询送达报告
    public function query() {

        try {

            //set request param
            $parameter = array(
                'appId' => $this->appid
            );

            $result = $this->getSoapClientHandler()->queryDeliveryReport($parameter);
            // bulog($result,'log',true);
            dump($result);
        } catch (SoapFault $soapFault) {
            throw new \think\Exception($soapFault->getMessage() . $this->getSoapClientHandler()->__getLastResponse());
        }
    }

    //查询接收短信，时间范围为跨度至当前时间
    public function query2() {

        try {

            //set request param
            $parameter = array(
                'appId' => $this->appid
            );

            $result = $this->getSoapClientHandler()->queryDeliveryReport($parameter);
            // bulog($result,'log',true);
            dump($result);
        } catch (SoapFault $soapFault) {
            throw new \think\Exception($soapFault->getMessage() . $this->getSoapClientHandler()->__getLastResponse());
        }
    }

    /**
     * @description getSoapClientHandler
     */
    public function getSoapClientHandler()
    {
        if (!self::$soapClientHandler) {
            self::$soapClientHandler = new \SoapClient($this->getSynchApi());
        }
        return self::$soapClientHandler;
    }

    /**
     * @description getSynchApi
     */
    public function getSynchApi()
    {
        return $this->apiurl;
    }

    /**************************************************************
     *
     *  将数组转换为JSON字符串（兼容中文）
     *  @param  array   $array      要转换的数组
     *  @return string      转换得到的json字符串
     *  @access public
     *
     *************************************************************/
    function tojson($array) {
        $this->arrayRecursive($array, 'urlencode', true);
        $json = json_encode($array);
        return urldecode($json);
    }

    /**************************************************************
     *
     *  使用特定function对数组中所有元素做处理
     *  @param  string  &$array     要处理的字符串
     *  @param  string  $function   要执行的函数
     *  @return boolean $apply_to_keys_also     是否也应用到key上
     *  @access public
     *
     *************************************************************/
    function arrayRecursive(&$array, $function, $apply_to_keys_also = false)
    {
        static $recursive_counter = 0;
        if (++$recursive_counter > 1000) {
            die('possible deep recursion attack');
        }
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $this->arrayRecursive($array[$key], $function, $apply_to_keys_also);
            } else {
                $array[$key] = $function($value);
            }

            if ($apply_to_keys_also && is_string($key)) {
                $new_key = $function($key);
                if ($new_key != $key) {
                    $array[$new_key] = $array[$key];
                    unset($array[$key]);
                }
            }
        }
        $recursive_counter--;
    }


}