<?php

namespace ScpoPHP;

require_once 'config.php';

use mysqli;
use ScpoPHP\Config\Db as Cfg;

function hh()
{
	return 'hh';
}

/**
 * 简单数据库操作
 * @link http://scpo-php.seventop.top/db/
 */
class Db
{
	/**
	 * sql连接
	 * @return \mysqli sql连接
	 */
	static public function link()
	{
		static $link = null, $linked = false;
		if ($linked) return $link;
		$link = mysqli_connect(...Cfg::$params);
		if ($link === false) throw new \Exception('link failed');
		else $linked = true;
		return $link;
	}
	/**
	 * 运行sql查询
	 * @param array|string $do 查询语句
	 * @return array|\mysqli_result|bool 查询结果
	 */
	static public function query($do)
	{
		if (is_array($do)) {
			$rslt = array();
			foreach ($do as $query) $rslt[] = mysqli_query(self::link(), $query);
			return $rslt;
		} else return mysqli_query(self::link(), $do);
	}
	/**上一次数据的ID */
	static public $lastID = 0;
	/**上一次操作的表 */
	static public $lastTable = '';
	/**
	 * 自动识别MySQL数据类型并进行转换
	 * @param mixed $data 数据
	 * @return string 转换后的字符串
	 */
	static public function test_data($data)
	{

		if (
			is_numeric($data)
			|| (substr($data, 0, 2) === '0x' &&
				ctype_xdigit(substr($data, 2))
			) || ($data[0] === '\'' &&
				substr($data, -1) === '\'' &&
				strpos(str_replace(array('\\\\', '\'\'', '\\\''), '', $data), '\'') === false
			)
		) return (string)$data;
		else if (
			$data[0] === '"' &&
			substr($data, -1) === '"' &&
			strpos(str_replace(array('\\\\', '""', '\"'), '', $data), '"') === false
		) return '\'' . str_replace(array('\"', '""'), '\'\'', $data) . '\'';
		else return '\'' . str_replace(array('\'', '\\'), array('\'\'', '\\\\'), $data) . '\'';
	}
	/**
	 * 转十六进制
	 * @param mixed $data 数据
	 * @return string 转换结果
	 */
	static public function to_hex($data)
	{
		return is_numeric($data) ? (string)$data : '0x' . bin2hex($data);
	}
	/**
	 * 处理WHERE子句内容
	 * @param array|string $where 内容
	 * @return string WHERE子句文本
	 */
	static public function cnv_where($where)
	{
		if (is_string($where)) return $where;
		else {
			$str = '   ';
			foreach ($where as $key => $val) $str .= " `$key`=" . self::to_hex($val) . ' AND';
			return substr($str, 0, -3);
		}
	}
	/**
	 * 插入数据
	 * @param array $data 数据
	 * @param string $table 目标表
	 * @param bool $getID 是否返回插入的数据的ID
	 * @return bool|int 结果
	 */
	static public function insert($data = array(), $table = '', $getID = false)
	{
		empty($table) ? $table = self::$lastTable : self::$lastTable = $table;
		$str0 = "INSERT INTO `$table`( ";
		$str1 = ') VALUES ( ';
		foreach ($data as $key => $val) {
			$str0 .= "`$key`,";
			$str1 .= self::to_hex($val) . ',';
		}
		$str = substr($str0, 0, -1) . substr($str1, 0, -1) . ')';
		$rslt = mysqli_query(self::link(), $str);
		if ($getID) $rslt = mysqli_fetch_array(mysqli_query(self::link(), 'SELECT LAST_INSERT_ID()'))[0];
		return self::$lastID = $rslt;
	}
	/**
	 * 修改数据
	 * @param array $data 数据
	 * @param array|string $where 筛选的条件
	 * @param string $table 目标表
	 * @return bool 结果
	 */
	static public function update($data = array(), $where = '', $table = '')
	{
		empty($table) ? $table = self::$lastTable : self::$lastTable = $table;
		if (empty($where)) $where = self::$lastID ? 'id' . self::$lastID : '`id`=LAST_INSERT_ID()';
		$str = "UPDATE `$table` SET ";
		foreach ($data as $key => $val) $str .= "`$key`=" . self::to_hex($val) . ',';
		$str = substr($str, 0, -1) . ' WHERE ' . self::cnv_where($where);
		$rslt = mysqli_query(self::link(), $str);
		return $rslt;
	}
	/**
	 * 查找数据
	 * @param array|string $where 筛选的条件
	 * @param array|string $what 查找的字段
	 * @param string $table 目标表
	 * @return array 结果
	 */
	static public function select($where = '', $what = '*', $table = '')
	{
		empty($table) ? $table = self::$lastTable : self::$lastTable = $table;
		if (empty($where)) $where = self::$lastID ? '`id`=' . self::$lastID : '`id`=LAST_INSERT_ID()';
		$str = 'SELECT ';
		if (is_string($what)) $str .= $what;
		else {
			foreach ($what as $val) $str .= "`$val`,";
			$str = substr($str, 0, -1);
		}
		$str .= " FROM `$table` WHERE   " . self::cnv_where($where);
		$r = mysqli_query(self::link(), $str);
		$rslt = array();
		while ($row = mysqli_fetch_array($r)) $rslt[] = $row;
		return $rslt;
	}
}
