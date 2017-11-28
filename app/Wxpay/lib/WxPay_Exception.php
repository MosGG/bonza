<?php
namespace App\wxpay\lib;
/**
 *
 * 微信支付API异常类
 * @author widyhu
 *
 */
use Exception;

class WxPayException extends Exception {
	public function errorMessage()
	{
		return $this->getMessage();
	}
}
