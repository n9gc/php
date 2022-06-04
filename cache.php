<?php

namespace ScpoPHP;

/**
 * 缓存相关实用函数
 * @link http://scpo-php.seventop.top/cache/
 */
class Cache {
	/**
	 * 检测文件是否被缓存
	 */
	static public function t_file($uri) {
		$date = gmdate("D, d M Y H:i:s T", filemtime($uri));
		$sign = str_replace(',', '_', $date);
		$head = getallheaders();
		if (isset($head[$t = 'If-None-Match']) && $head[$t] == $sign) die(header('HTTP/1.1 304'));
		else header("ETag: $sign");
		header("Last-Modified: $date");
	}
}
