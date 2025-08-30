<?php

namespace ScpoPHP;

require_once 'config.php';

use ScpoPHP\Config\Cookie as Cfg;

/**
 * cookie简便函数
 * @link http://scpo-php.seventop.top/cookie/
 */
class Cookie
{
	/**
	 * 发送一个cookie
	 * @param string $name 名称
	 * @param string $value 值
	 * @param string $path 作用路径
	 * @param string $domain 作用域名
	 * @param bool $secure 仅限安全连接
	 * @param bool $httponly 仅限http连接
	 * @param bool 是否成功发送
	 */
	static public function set(
		$name,
		$value = null,
		$expires_or_options = null,
		$path = null,
		$domain = null,
		$secure = null,
		$httponly = null
	) {
		return setcookie(...self::getParams(
			Cfg::$now->params,
			$name,
			$value,
			$expires_or_options,
			$path,
			$domain,
			$secure,
			$httponly
		));
	}
	static public function getParams(
		$default,
		$name,
		$value = null,
		$expires_or_options = null,
		$path = null,
		$domain = null,
		$secure = null,
		$httponly = null
	) {
		$xop = array(
			'name' => $name,
			'value' => $value,
			'expires_or_options' => $expires_or_options,
			'path' => $path,
			'domain' => $domain,
			'secure' => $secure,
			'httponly' => $httponly
		);
		foreach ($xop as $param => $val) if (!is_null($val)) $default[$param] = $val;
		return $default;
	}
}
