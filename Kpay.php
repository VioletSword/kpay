<?php
/**
 * 
 * @authors kk (15625591878@163.com)
 * @date    2019-01-01 21:23:11
 * @version 2.1
 */

defined('DS') or define('DS',DIRECTORY_SEPARATOR);

class Kpay {
    //应用ID,您的APPID。
	public $appId  = '2016091800536922';

	//私钥值
	public $rsaPrivateKey = 'MIIEvgIBADANBgkqhkiG9w0BAQEFAASCBKgwggSkAgEAAoIBAQDO3NQQ+OnTB3ZTtyG4Az4T0rP6yGMn/PQbSH2eIVr6KoOaHOnWGjeSWWMNACzXBpvdynLAeEtkdH7xzsxyknf91vk8tsjCHOGkExfl/XX5b28GXGrgyphBJ/ImU1OMHtDaTAU5jVLZY63PvkP5N6ZgdY8pAkgjwTMGZarcmL8uGBWOMZGputmOO3iBkdMbljOUThrsuF1wCRBoTewIe078RRAosE/y0grXnWRvz1N/XQdtMYSEr26DacSxVIegELS7GJw8qBEUwqUMbshdqvhGXuE4MyBYvnA8vR376xJrP5iVGctlRF54/7Qol1mAaRt9n3Z+oLcSu+fngJ4jdi13AgMBAAECggEBAMSpOk88ZQeEA6FI7ByFsKGl4gdcNLBSkjvR6eLIsTY97sk4DbLHT+epZTp53Sc7mDj9+6QxePNysTDvunx99Od1VZO77hZk4Ltcj47OLTdLElEI0W8ODDt9X3/CHh6LOWEffqQdUBNt6VMj/nlSx7DScpy5F54uUXUWeJ6p9K867sXUGyg0T+wubKuXX1b7ADknUm1IyDBxWi3Kx7tDNmCht7/5/61BnsOqN6Td8WoYUdIPnE0NGLFIF97Pyo/W75cX5+tkA+DGJVDYNUbPurL3oQpdGuH7QYgLMWP7+9TOWtSMlAGjEQmT5XHsuQKDkI2i5akBeNPGk5K3hzcfUDECgYEA6LQ4UANCUnRq9kZ1dWgDwEn64XaPq3pO1pRmkdFxBhOmcSgmMFq855OGm9FD7tgeoenYlrSHEZw1tHOMxzHbtRgBeOtwrgS+qytryfxGYFZr1vreUgnWFVJI8F+k4ikCHqTEIF1ARG1eIiubMuSVjSo3AiJNU8PSbeK4QiYxCN8CgYEA45JXS4jqBWIlDFxzGGNpZfb83wHseGHOxpEJdjALB6xv9bQcx+tFykrcQ7xSpBjwoiQpI0Y8O/UCh++MvDQ70DeRmeziI+LfMIBrXpi59MxBNMYruZMkaWG62RuUjolWoL4uQyF2Lirz87aPIbwS+8iwNbF+KEWPBg3kOLVVtmkCgYBCSdxkxpjk/i7eGvIo0MmIxEpIYcrJcVz1+W5CiaQltAFM6MAANEjtuvO0fWdZqY0IWKIPRDvZw2L1FZl7wPMyYjVBKeh+WfGqtwLMliXCGbw8kFg2jIDEsB0BBG3m0wG8kvkfsxC0rWcMWtmqJL2JagYjgHwAqZ7PGK+egFylhwKBgQDdjOwVqn6CrTD6XsridG35CcLXbW0FKdt/71WxzUX/u33oS+g1LbTtI4JbI22lOm6Su/ec0tTzXi2Pn8R4ubV9mYvTug3S+B1nf66IEtH/JBdbRI7vBPRO8AlTMomnVseSiHRLgLkoa0LDAvlH02z72T7LlzgGBuod78o+9zMx+QKBgEhnHFxp7N50ZKxDUQW4lrCMuybxyoqPvw5YvKFYWxcdaL6dzzhV4SllJMeE/BCGbSfmKTyECVnJjLQjcqpNR4hIlgoLJKrqJoiQNOmi6q9NR0EVQoi6CCvbLgVKr+4+lgtD86WYDItalqNnHObBd2NLXKwYpWe7CA+O29WXRLD+';

	//支付宝公钥，使用读取字符串格式，请只传递该值
	public $alipayrsaPublicKey = 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEApP6efEMwAcl0+HXBOVSe4rdfJqKML8Fz3Qv1qfzkjCFNIQZJyUMjKJVT2/svOefzSsEe7ZZ3XR3e0bFs5t8F4CAtYbjUjKkzNONkznu4flxUOF3O0SYvLomd75j3104XjA6v5n7bwlW7KqzNvCdxp37bmVSzbgdeyutl+s6Uy1SIreklGHXxHjUZk7qeyND1PCOu4fm6jJQtHMuf8RtzCd+l16xrzcWoHj+Wbf55okDOd3UIDVnAgG0cQfHUtjX0JcKCmPpsHhjlBYVRTT8+1Zw64+xmJcrx0RHx9aNOOZRgX0f8s1IWJFSi82bz9lSCrtrDskdhBF8+PqIcbel7RQIDAQAB';

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