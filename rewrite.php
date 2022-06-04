<?php

namespace ScpoPHP;

/**
 * 重写url时更加方便
 * @link http://scpo-php.seventop.top/rewrite/
 */
class Rewrite {
	/**
	 * 获取伪静态下访问的uri和get请求字符串
	 * @return array 数组，分别为uri和get请求
	 */
	static public function uri_get() {
		if (($pos = strpos($uri = $_SERVER['QUERY_STRING'], '&')) !== false) {
			$get = substr($uri, $pos);
			$uri = substr($uri, 0, $pos);
			$get[0] = '?';
		} else $get = '';
		return array($uri, $get);
	}
}
