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
	 * @return string 域名
	 */
	static public function dmn()
	{
		if (substr_count($dmn = $_SERVER['HTTP_HOST'], '.') === 2) $dmn = substr($dmn, strpos($dmn, '.') + 1);
		if (($pos = strpos($dmn, ':')) !== false) $dmn = substr($dmn, 0, $pos);
		return $dmn;
	}
	/**
	 * 获取伪静态下访问的uri和get请求字符串
	 * @return array 数组，分别为uri和get请求
	 */
	static public function rewrite_uriget()
	{
		if (($pos = strpos($uri = $_SERVER['QUERY_STRING'], '&')) !== false) {
			$get = substr($uri, $pos);
			$uri = substr($uri, 0, $pos);
			$get[0] = '?';
		} else $get = '';
		return array($uri, $get);
	}
}
