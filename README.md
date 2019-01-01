# kpay
支付宝功能封装

使用的支付宝SDK版本为alipay-sdk-PHP-3.3.1

引入自己项目时不需要包含alipay-sdk-PHP-3.3.1.zi压缩包，此压缩包仅做一个SDK备份，使用时可删除此压缩包

使用说明：

1.将kpay文件夹引入自己的项目，并将Kpay.php的支付宝应用信息换成自己的支付宝应用信息如下:

```php
//应用ID,您的APPID。
public $appId  = '2016091800536922';

//商户私钥值
public $rsaPrivateKey = '你的支付宝应用商户私钥';

//支付宝公钥，使用读取字符串格式，请只传递该值
public $alipayrsaPublicKey = '你的支付宝公钥';

//网关
public $gatewayUrl = "https://openapi.alipaydev.com/gateway.do";
protected $notify_url = '';  //异步通知地址
protected $return_url = '';  //同步跳转地址
```

2.在自己的项目的引入Kpay.php文件后即可使用相应的功能

`require_once yourdirname.'kpay/Kpay.php';`

功能调用示例：

```php
//调用支付能力示例
$alipay = new \Kpay();   //实例化Kpay类
//定义支付信息
$data_pay = [
'out_trade_no' => '2018122812345678992',
'subject'      => '买个锤子',
'total_amount' => '0.01'
];
//使用电脑网站统一支付功能
$alipay->alipayTradePagePay($data_pay);
```

注意：

1.支付信息参数必须与支付宝API文档里的参数一致，如这里的商户订单号参数`out_trade_no`

2.调用相应能力时类名也必须与支付宝API文档里的API列表的名字一致，如这里的电脑网站一统一支付功能`alipayTradePagePay`；

