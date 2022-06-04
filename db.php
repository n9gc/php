<?php

namespace ScpoPHP;

require_once 'config.php';
use ScpoPHP\Config\Sql as Cfg;

/**
 * 简单数据库操作
 * @link http://scpo-php.seventop.top/db/
 */
class Db {
	/**
	 * sql连接
	 * @return \mysqli sql连接
	 */
	static public function link()
	{
		static $link = null, $linked = false;
		if ($linked) return $link;
		$link = mysqli_connect(
			Cfg::$host,
			Cfg::$name,
			Cfg::$pwd,
			Cfg::$db,
			Cfg::$port,
			Cfg::$socket
		);
		if ($link === false) throw new \Exception('link failed');
		else $linked = true;
		return $link;
	}
	/**上一次数据的ID */
	static public $lastID = 0;
	/**上一次操作的表 */
	static public $lastTable = '';
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
			$str1 .= "'$val',";
		}
		$str = substr($str0, 0, -1) . substr($str1, 0, -1) . ')';
		$rslt = mysqli_query(self::link(), $str);
		if ($getID) {
			$rslt = mysqli_query(self::link(), 'SELECT LAST_INSERT_ID()');
			$rslt = mysqli_fetch_array($rslt)[0];
		}
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
		foreach ($data as $key => $val) $str .= "`$key`='$val',";
		$str = substr($str, 0, -1) . ' WHERE ';
		if (is_string($where)) $str .= $where;
		else {
			foreach ($where as $key => $val) $str .= "`{$key}`='{$val}',";
			$str = substr($str, 0, -1);
		}
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
	static public function sql_select($where = '', $what = '*', $table = '')
	{
		empty($table) ? $table = self::$lastTable : self::$lastTable = $table;
		if (empty($where)) $where = self::$lastID ? '`id`=' . self::$lastID : '`id`=LAST_INSERT_ID()';
		$str = 'SELECT ';
		if (is_string($what)) $str .= $what;
		else {
			foreach ($what as $val) $str .= "`$val`,";
			$str = substr($str, 0, -1);
		}
		$str .= " FROM `$table` WHERE ";
		if (is_string($where)) $str .= $where;
		else {
			foreach ($where as $key => $val) $str .= "`$key`='$val',";
			$str = substr($str, 0, -1);
		}
		$r = mysqli_query(self::link(), $str);
		$rslt = array();
		while ($row = mysqli_fetch_array($r)) array_push($rslt, $row);
		return $rslt;
	}
}
