<?php
/**
 * 
 * @authors kk (15625591878@163.com)
 * @date    2019-01-01 21:23:11
 * @version 2.2
 */

defined('DS') or define('DS',DIRECTORY_SEPARATOR);

/**
* SDK工作目录
* 存放日志，TOP缓存数据
*/
if (!defined("AOP_SDK_WORK_DIR"))
{
        define("AOP_SDK_WORK_DIR", "/tmp/");
}

/**
* 是否处于开发模式
* 在你自己电脑上开发程序的时候千万不要设为false，以免缓存造成你的代码修改了不生效
* 部署到生产环境正式运营后，如果性能压力大，可以把此常量设定为false，能提高运行速度（对应的代价就是你下次升级程序时要清一下缓存）
*/
if (!defined("AOP_SDK_DEV_MODE"))
{
        define("AOP_SDK_DEV_MODE", true);
}

class Kpay {
    //应用ID,您的APPID。
	public $appId  = '2016091800536922';

	//私钥值
	public $rsaPrivateKey = '';

	//支付宝公钥，使用读取字符串格式，请只传递该值
	public $alipayrsaPublicKey = '';

	//网关
	public $gatewayUrl = "https://openapi.alipaydev.com/gateway.do";
  protected $notify_url = 'http://www.phptest.com/index.php/home/AliPay/return_notifyUrl';  //异步通知地址
  protected $return_url = 'http://www.phptest.com/index.php/home/AliPay/return_url';  //同步跳转地址

	//签名类型
	public $signType = "RSA2";

	public $aop;

    public function __construct(){
      spl_autoload_register('self::alipay_autoload');
      $this->aop = new AopClient();
      $this->aop->gatewayUrl = $this->gatewayUrl;
      $this->aop->appId = $this->appId;
      $this->aop->rsaPrivateKey = $this->rsaPrivateKey;
      $this->aop->alipayrsaPublicKey = $this->alipayrsaPublicKey;
      $this->aop->signType = $this->signType;
        
    }

    /**
   * [alipayTradePagePay 电脑网站统一收单下单并支付]
   * @return [type] [description]
   */
  public function alipayTradePagePay($data){
    $data['product_code'] = 'FAST_INSTANT_TRADE_PAY';
    $data = json_encode($data);  //将参数转为json字符串

    $request = new AlipayTradePagePayRequest();  
    $request->setReturnUrl($this->return_url);  
    $request->setNotifyUrl($this->notify_url);
    
    /*'{
      "product_code": "FAST_INSTANT_TRADE_PAY",
      "out_trade_no": "'.$data['out_trade_no'].'",
      "subject": "'.$data['subject'].'",
      "total_amount": "'.$data['total_amount'].'"
    }'*/
    $request->setBizContent($data);

    //请求  
    $result = $this->aop->pageExecute($request);

    //输出  
    echo $result;
  }

  /**
   * [alipayTradePagePay 手机网站下单并支付]
   * @return [type] [description]
   */
  public function alipayTradeWapPay($data){
    $data['product_code'] = 'QUICK_WAP_WAY';
    $data['timeout_express'] = '30m';
    $data = json_encode($data);  //将参数转为json字符串
    
    $request = new AlipayTradeWapPayRequest();  
    $request->setReturnUrl($this->return_url);  
    $request->setNotifyUrl($this->notify_url); 
     
    $request->setBizContent($data);

    //请求  
    $result = $this->aop->pageExecute($request);

    //输出  
    echo $result;
  }

  /**
   * [alipayTradeRefund 统一收单交易退款接口]
   * @return [type] [description]
   */
  public function alipayTradeRefund($data){
    
    $data = json_encode($data);

    $request = new AlipayTradeRefundRequest();
    /*$request->setBizContent('{
      "out_trade_no":"'.$data['out_trade_no'].'",
      "trade_no":"'.$data['trade_no'].'",
      "refund_amount":"'.$data['refund_amount'].'",
      "refund_reason":"正常退款"
    }');*/
     $request->setBizContent($data);
    $result = $this->aop->execute($request); 
    echo '<pre>';
    print_r($result);
    $responseNode = str_replace(".", "_", $request->getApiMethodName()) . "_response";
    $resultCode = $result->$responseNode->code;
    if(!empty($resultCode)&&$resultCode == 10000){
      //echo "成功";
      return true;
    } else {
      //echo "失败";
      return false;
    }
  }
  
  /**
   * [alipayUserInfoAuthRequest description] 用户登陆授权
   * @param  [type] $data [description]
   * @return [type]       [description]
   */
  public function alipayUserInfoAuthRequest ($data){
    $data = json_encode($data);  //将参数转为json字符串

    $request = new AlipayUserInfoAuthRequest();  
    $request->setReturnUrl($this->return_url);  
    $request->setNotifyUrl($this->notify_url);
    
    $request->setBizContent($data);

    //请求  
    $result = $this->aop->execute($request);

    //输出  
    echo $result;
  }

  /**
   * 验签方法，验签支付宝返回的信息，需要使用到支付宝公钥
   * @return boolean
   */
  public function check($arr){
    return $this->aop->rsaCheckV1($arr, $this->aop->alipayrsaPublicKey, $this->aop->signType);
  }

  /**
   * [alipay_autoload 支付宝自动加类方法]
   * @param  [type] $className [类名]
   * @return [type]            [description]
   */
  public static function alipay_autoload($className){
    $file = __DIR__.DS.'aop'.DS.$className.'.php';
    //echo $file;
    
    if(file_exists($file)){
      require_once $file;
    }else{
      $file = __DIR__.DS.'aop'.DS.'request'.DS.$className.'.php';
      if(file_exists($file)){
        require_once $file;
        //echo $file;
      }
    }
  }

}