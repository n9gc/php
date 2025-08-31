<?php

namespace ScpoPHP;

use ScpoPHP\Config\Errpage as Cfg;

/**
 * 快速优雅地抛出错误
 * @link http://scpo-php.seventop.top/errpage/
 */
class Errpage
{
	/**各错误码对应信息 */
	static $code_info = array(
		404 => 'Not Found',
		418 => 'I\'m a teapot'
	);
	/**
	 * 发出错误
	 */
	static public function die($code)
	{
		$info = isset(self::$code_info[$code]) ? ' ' . self::$code_info[$code] : '';
		header("HTTP/1.1 $code$info");
		echo "\"^_^ <b>Surprise!</b><br />$code $info\"";
		die();
	}
	/**
	 * 快速重定向
	 */
	static public function get_ret($file)
	{
		static $location = 'Location: //' . $_SERVER['HTTP_HOST'] . Cfg::$now->callback_page . "$file:%0A";
		return function ($info) use ($location) {
			header($location . urlencode($info));
			die();
		};
	}
}
