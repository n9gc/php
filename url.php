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
	static public function dmn($port = false)
	{
		static $dmn = array();
		if (isset($dmn[1])) {
			if ($port) return $dmn[1];
			if (isset($dmn[0])) return $dmn[0];
		} else {
			$dmn[1] = explode('.', $_SERVER['HTTP_HOST']);
			$dmn[1] = array(array_pop($dmn[1]), array_pop($dmn[1]));
			$dmn[1] = "{$dmn[1][1]}.{$dmn[1][0]}";
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
	/**
	 * 替换查询字符串
	 */
	static public function rep_query($url, $arr)
	{
		$base = ($qm = strpos($url, '?')) === false
			? $url
			: (($hash = strpos($url, '#', $qm)) === false
				? substr($url, 0, $qm)
				: substr($url, 0, $qm) . substr($url, $hash));
		[$path, $hash] = array_pad(explode('#', $base, 2), 2, '');
		$query = $arr ? '?' . http_build_query($arr, '', '&', PHP_QUERY_RFC3986) : '';
		return $path . $query . ($hash === '' ? '' : '#' . $hash);
	}
}
