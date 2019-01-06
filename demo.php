<?php

require_once 'Kpay.php';




	/********************************支付宝*************************************************/
	//支付测试
	
		$alipay = new \Kpay();
		
		$data_pay = [
			'out_trade_no' => '2018122812345679091',
			'subject'      => '买个锤子',
			'total_amount' => '0.01',
		];
		
		$alipay->alipayTradePagePay($data_pay);
		
		
		die;
		/**/
	
	//退款测试
	
	$data_refundy = [
		'out_trade_no' => '2018122812345679091',
		'trade_no'      => '2019010122001425430500705818',
		'refund_amount' => '0.01',
		'refund_reason' => '正常退款'
	];
	
	$result = $alipay->alipayTradeRefund($data_refundy);
	if($result){
		echo '退款成功啦~';
	}else{
		echo '退款失败啦~';
	}
	
	
	/*//同步跳转地址
	public function return_url(){
		$data = input();
		echo '<pre>';
		print_r($data);
		
		$alipay = new \Kpay();
		$result = $alipay->check($data);
		if($result){
			//saveLog('alipay/notify_url_test','验签通过啦~');
			echo 'success';
		}else{
			//saveLog('alipay/notify_url_test','验签不通过，嘿嘿~');
			echo '验签不通过，嘿嘿';
		}
		
	}
	
	//异步通知测试
	public function notify_url(){
		$data = input();
		$dataJson = json_encode($data);
		saveLog('alipay/notify_url_test',$dataJson);
		try{
			$alipay = new AliPay(1);
			$result = $alipay->check($data);
		}catch(\Exception $e){
			saveLog('alipay/notify_url_test','出错啦~'.$e->getMessage());
		}
		
		if($result){
			saveLog('alipay/notify_url_test','异步通知，验签通过啦~');
			echo 'success';
		}else{
			saveLog('alipay/notify_url_test','验签不通过，嘿嘿~');
			echo '验签不通过，嘿嘿';
		}
		
	}*/