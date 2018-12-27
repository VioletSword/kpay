<?php
namespace app\home\controller;

use think\Controller;
//use aop\AopClient;
require_once EXTEND_PATH.'aop'.DS.'AopClient.php';

class AliPay extends Controller {

	private $gatewayUrl = 'https://openapi.alipaydev.com/gateway.do';
	private $appId = '2016091800536922';
	private $rsaPrivateKey = 'MIIEwAIBADANBgkqhkiG9w0BAQEFAASCBKowggSmAgEAAoIBAQDgO2LTVLgzpsQKk4t3TxdW5qVCn52ZLw2Jmx8hFDAxsepxdkbdfAKHF77KQrmrXm63QjDCyr3YueALsPNx3UPx73uzz2GA3k0C7hPgF4kgMZKhP9dT41Q6Iji382d7t4DNfsaHC5fpNs/ZzQaqJJ15/lu3hXb5QyyLAKscwqoWhouLIsurRf0xMxnIX2KT+GeS16wwEPX0oFNbztUZ3iciYYCcEZlY8ScIU+7ISvhyWEsZXjhb89PAHmc6Ngn6QKD847CVKVhkGN3U/jeT9U0C8OW85jMp+aRPeQyLE6hktS2tebYpRhzQjxBDzrp/XJK7zSiNuRrTn4KSovpjgFUxAgMBAAECggEBAKNlIuJ0PbYFs50xXtOV4qAEejBON31EeEzpqIlmOKg9yWTcl08V6pGej/y7GqjxqyQHK5kGO8kNyWE7lGpInhZSOIYSfC53zw5vhjQpclbvSLYP20zZvqqN/V6uE55nXYhg9TG7FPtwYY2IhW6+N7KJ0zOsIcIJXQ/9cLMIdwDptNtyp6QOvo5m6vIDH05kF/yt79fKsQLpv9jwVJIJCm3Lk7V/rfGj01wgetWEdLGny9+pQdMm0ET5NCdUCxCLMNEXiMF5iFsiQaB5v8ZtMiApJLD91PadQKAaNc/oSxu7Ovyp5ft6hO66XbtFRM/dnpTlN1PQhsi34sug9swAq0ECgYEA8g+ET4f32b/fZgsfwzRso8/HCntLYp+3TRIWkP2oC1V0AgIS7/Ga96Xnw8I2jdv3tlTACobH86H7QvJ0dpcQ3Rbg3phfj6U4xde5hSjqS3mzKvLJWnj/s/8dM8D9XzT8Y3FdbYCh5vnN3x0C71P+FaG1IeDU+mmpoOgaDddcAkUCgYEA7SUJnZ3FYv3aI2frHHsqubONRex3IpnKJ3zb2iwiZo4BUhTc1CcQg3tGaedFW3sOns5TQGZKJ7b94+3TciCTGaqSLH15C0GS5bFCNVKX8YhopxKTATGIXN6BmLVXTedR6qJ+LOIwokmage/+rQPx7znZ3RJbZXkVnmd267+2q/0CgYEAk5HmJd5MudGBzmIlwQnq2YtIWxmDgeLBCxll7IrXseEs0jSVevaedTANtYhnXeCmid/tG/3DVMKBvfS2D75VJ5RVDx9x0s71Z5f2oDmrbMwK8LoHC0MNEJ0NHoofbbWN0MpCHQn4qinM2qKDMYjRNDrbhIXfEbLtGQ2nJJ0QmMkCgYEAnb90fQd1RRtOHx1CdYis7Ci3QhtBSJ/6rHfPG3seSxANatd76hguUPgQ5+Oy7F6YZCUllgI1M+PzUcpjTFjE4V7oq3WvrkApgmd+fk/5yO6PhwvBBBs59WUB2l5OvACzKhx7SEoSRfImOGc4B0lHh3X5KajLaV25dsyme73kutUCgYEA3WBJhY2rPnwxXPh/YGjmhsl1wWjGqldn4h+8WSZhrmc31elQ/Bii03CybldXqU+UcumAqwvNUxviHgJ/p7GFXVQsY0p3EYt3xJ9/fGW+BDtm/K252dmgQZM+X0Hsq8FHr2xsANoVSNyd945yZbTLKh7hgsX4ul6HMWxL/J2XDJA=';   //请填写商户私钥
	private $alipayrsaPublicKey = 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEApP6efEMwAcl0+HXBOVSe4rdfJqKML8Fz3Qv1qfzkjCFNIQZJyUMjKJVT2/svOefzSsEe7ZZ3XR3e0bFs5t8F4CAtYbjUjKkzNONkznu4flxUOF3O0SYvLomd75j3104XjA6v5n7bwlW7KqzNvCdxp37bmVSzbgdeyutl+s6Uy1SIreklGHXxHjUZk7qeyND1PCOu4fm6jJQtHMuf8RtzCd+l16xrzcWoHj+Wbf55okDOd3UIDVnAgG0cQfHUtjX0JcKCmPpsHhjlBYVRTT8+1Zw64+xmJcrx0RHx9aNOOZRgX0f8s1IWJFSi82bz9lSCrtrDskdhBF8+PqIcbel7RQIDAQAB';   //支付宝公钥

	private $notify_url = '';  //异步通知地址
	private $return_url = 'http://www.kpay.com/index.php/home/Index/index';  //同步跳转地址

	/**
	 * [alipayTradePagePay 电脑网站统一收单下单并支付]
	 * @return [type] [description]
	 */
	public function alipayTradePagePay(){
		//构造参数  
		$aop = new \AopClient ();  
		$aop->gatewayUrl = $this->gatewayUrl;  
		$aop->appId = $this->appId;  
		$aop->rsaPrivateKey = $this->rsaPrivateKey;
		$aop->alipayrsaPublicKey = $this->alipayrsaPublicKey;  
		$aop->apiVersion = '1.0';  
		$aop->signType = 'RSA2';  
		$aop->postCharset= 'utf-8';  
		$aop->format='json';  
		$request = new \AlipayTradePagePayRequest ();  
		$request->setReturnUrl($this->return_url);  
		$request->setNotifyUrl($this->notify_url);  
		$request->setBizContent('{
		  "product_code": "FAST_INSTANT_TRADE_PAY",
		  "out_trade_no": "20150320010101019",
		  "subject": "Iphone6 16G",
		  "total_amount": "1.00",
		  "body": "Iphone6 16G"
		}');

		//请求  
		$result = $aop->pageExecute($request);

		//输出  
		echo $result;
	}

	/**
	 * [alipayTradeRefund 电脑网站统一收单交易退款接口]
	 * @return [type] [description]
	 */
	public function alipayTradeRefund(){
		//构造参数  
		$aop = new \AopClient ();  
		$aop->gatewayUrl = $this->gatewayUrl;  
		$aop->appId = $this->appId;  
		$aop->rsaPrivateKey = $this->rsaPrivateKey;
		$aop->alipayrsaPublicKey = $this->alipayrsaPublicKey;  
		$aop->apiVersion = '1.0';  
		$aop->signType = 'RSA2';  
		$aop->postCharset= 'utf-8';  
		$aop->format='json';
		$request = new \AlipayTradeRefundRequest ();
		$request->setBizContent('{
			"out_trade_no":"20150320010101018",
			"trade_no":"2018122722001425430500697038",
			"refund_amount":1.00,
			"refund_reason":"正常退款"
		}');
		$result = $aop->execute($request); 
		echo '<pre>';
		print_r($result);
		$responseNode = str_replace(".", "_", $request->getApiMethodName()) . "_response";
		$resultCode = $result->$responseNode->code;
		if(!empty($resultCode)&&$resultCode == 10000){
			echo "成功";
		} else {
			echo "失败";
		}
	}
}