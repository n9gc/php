<?php

namespace ScpoPHP;

class S2h2b {
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
	 * 字符串转十六进制字符串
	 * @param string $str 字符串
	 * @return string 十六进制字符串
	 */
	static public function str2hex($s)
	{
		for ($r = '', $i = 0; $i < strlen($s); $i++) $r .= unpack('H*', $s[$i])[1];
		return $r;
	}
	/**
	 * 十六进制字符串转字符串
	 * @param string $str 十六进制字符串
	 * @return string 字符串
	 */
	static public function hex2str($s)
	{
		return hex2bin($s);
		// for ($c = 0, $d = 0, $h = '', $s = strtolower($s), $r = '', $l = strlen($s), $i = 0; $i < $l; $i += 2) ($t = $s[$i] . $s[$i + 1])[0] < 8 ? $r .= pack('H2', $t) : ($t[0] > 'b' ? ($d = ($c = ($d = (int)base_convert($t[0], 16, 10)) - 10 - (int)($d / 13)) - 1 and $h = $t) : (--$d == 0 ? $r .= pack('H' . 2 * $c, $h . $t) : $h .= $t));
		// return $r;
	}
	/**
	 * 字符串转二进制字符串
	 * @param string $s 字符串
	 * @return string 二进制字符串
	 */
	static public function str2bin($s)
	{
		return self::hex2bin(self::str2hex($s));
	}
	/**
	 * 二进制字符串转字符串
	 * @param string $s 二进制字符串
	 * @return string 字符串
	 */
	static public function bin2str($s)
	{
		return self::hex2str(self::bin2hex($s));
	}
}
