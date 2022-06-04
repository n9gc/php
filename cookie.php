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
		$value = Cfg\NO_PARAM_SIGN,
		$expires_or_options = Cfg\NO_PARAM_SIGN,
		$path = Cfg\NO_PARAM_SIGN,
		$domain = Cfg\NO_PARAM_SIGN,
		$secure = Cfg\NO_PARAM_SIGN,
		$httponly = Cfg\NO_PARAM_SIGN
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
		$dop = Cfg::$params;
		foreach ($xop as $param => $val) if ($val !== Cfg\NO_PARAM_SIGN) $dop[$param] = $val;
		return setcookie(...$dop);
	}
}
