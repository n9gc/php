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
	static public function get_ret($file, $from = '')
	{
		static $location = 'Location: //' . $_SERVER['HTTP_HOST'] . Cfg::$now->callback_page . Cfg::$now->callback_query;
		$ret = function ($info) use ($location, $file) {
			header($location . urlencode("$file:\n$info"));
			die();
		};
		$end = function ($info) use ($from, $ret) {
			if (!$from) $ret('No $from but using end function in ScpoPHP\Errpage:' . __LINE__);
			if (!str_ends_with($from, '?')) $from .= '?';
			header("Location: $from" . Cfg::$now->callback_query . urlencode($info));
			die();
		};
		return [$ret, $end];
	}
}
