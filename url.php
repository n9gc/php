<?php

namespace ScpoPHP;

/**
 * url操作相关
 * @link http://scpo-php.seventop.top/rewrite/
 */
class Url
{
	/**
	 * 获取域名
	 * @param bool $port 是否包含端口
	 * @return string 域名
	 */
	static public function dmn($port)
	{
		static $dmn = array();
		if (isset($dmn[1])) {
			if ($port) return $dmn[1];
			if (isset($dmn[0])) return $dmn[0];
		} else {
			$dmn[1] = $_SERVER['HTTP_HOST'];
			if (substr_count($dmn[1], '.') === 2) $dmn[1] = substr($dmn[1], strpos($dmn[1], '.') + 1);
		}
		return $port
			? $dmn[1]
			: ($dmn[0] = ($pos = strpos($dmn[1], ':')) !== false
				? substr($dmn[1], 0, $pos)
				: $dmn[1]
			);
	}
	/**
	 * 获取伪静态下访问的uri和get请求字符串
	 * @return array 数组，分别为uri和get请求
	 */
	static public function rewrite_uriget()
	{
		static $mem;
		if ($mem) return $mem;
		if (($pos = strpos($uri = $_SERVER['QUERY_STRING'], '&')) !== false) {
			$get = substr($uri, $pos + 1);
			$uri = substr($uri, 0, $pos);
		} else $get = '';
		return $mem = array($uri, $get);
	}
}
