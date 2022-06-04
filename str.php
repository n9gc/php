<?php

namespace ScpoPHP;

/**
 * 字符串、十六进制字符串和二进制字符串相互转换
 * @link http://scpo-php.seventop.top/str/
 */
class Str {
	/**
	 * 获取一个随机字符串
	 * @param int $length 字符串长度
	 * @param string set 字符集合
	 * @return string 随机字符串
	 */
	static public function rand($length = 32, $set = '0123456789ABCDEF')
	{
		$str = '';
		$m = strlen($set) - 1;
		for ($i = 0; $i < $length; $i++) $str .= $set[rand(0, $m)];
		return $str;
	}
	/**
	 * 十六进制字符串转二进制字符串
	 * @param string $s 十六进制字符串
	 * @return string 二进制字符串
	 */
	static public function hex2bin($s)
	{
		for ($r = '', $l = strlen($s), $i = 0; $i < $l; $i += 2) $r .= str_pad(base_convert($s[$i] . $s[$i + 1], 16, 2), 8, '0', STR_PAD_LEFT);
		return $r;
	}
	/**
	 * 二进制字符串转十六进制字符串
	 * @param string $s 二进制字符串
	 * @return string 十六进制字符串
	 */
	static public function bin2hex($s)
	{
		for ($r = '', $l = strlen($s), $i = 0; $i < $l; $i += 8) $r .= str_pad(base_convert(substr($s, $i, 8), 2, 16), 2, '0', STR_PAD_LEFT);
		return $r;
	}
	/**
	 * 字符串转二进制字符串
	 * @param string $s 字符串
	 * @return string 二进制字符串
	 */
	static public function str2bin($s)
	{
		return self::hex2bin(bin2hex($s));
	}
	/**
	 * 二进制字符串转字符串
	 * @param string $s 二进制字符串
	 * @return string 字符串
	 */
	static public function bin2str($s)
	{
		return hex2bin(self::bin2hex($s));
	}
}
