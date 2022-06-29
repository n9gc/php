<?php

namespace ScpoPHP;

require_once 'config.php';
require_once 'db.php'; // 请注意不要重复引入db.php
require_once 'cookie.php'; // 请注意不要重复引入cookie.php

use ScpoPHP\Config\User as Cfg;
use ScpoPHP\Config\User\Acct as CAcct;
use ScpoPHP\Config\User\Acct\Table as CAcTable;
use ScpoPHP\Config\User\Acct\Table\Recov as CAcTaRecov;
use ScpoPHP\Config\User\Auth as CAuth;
use ScpoPHP\Config\User\Auth\Cookie as CAuCookie;
use ScpoPHP\Config\User\Auth\Session as CAuSession;

/**
 * ScpoUS简便账号系统实现函数
 * @link http://scpo-php.seventop.top/user/
 */
class User
{
	/**
	 * 简单初始化数据库
	 * 如果已经有数据库了则不需要初始化
	 * @return bool 初始化是否成功
	 */
	static public function db_init()
	{
		$table = CAcTable::$table;
		if (Db::query("SHOW TABLES like '$table'")->num_rows === 1) return false;
		$f = Db::query(
			'CREATE TABLE `' . \ScpoPHP\Config\Db::$params['database'] . '`.`' . $table . '` (
				`' . CAcTable::$identity . '` INT NOT NULL AUTO_INCREMENT COMMENT \'主键\' ,
				`' . CAcTable::$password . '` BINARY(16) NOT NULL COMMENT \'密码\' ,
				`' . CAcTable::$salt . '` BINARY(4) NOT NULL COMMENT \'盐\' ,
				PRIMARY KEY (`' . CAcTable::$identity . '`)
			) ENGINE = InnoDB COMMENT = \'Scpo-UserSystem：用户表\';'
		);
		if (!$f) return false;
		return self::db_init_recov();
	}
	/**
	 * 初始化复用数据库
	 * @return array 是否成功初始化
	 */
	static public function db_init_recov()
	{
		$table = CAcTable::$table;
		if (!CAcTaRecov::$enable) return false;
		if (Db::query("SHOW TABLES like '$table'")->num_rows === 0) return false;
		$suffix = CAcTaRecov::$suffix;
		$column = CAcTaRecov::$column;
		$desc = Db::query("DESC $table");
		$type = array();
		while ($row = mysqli_fetch_array($desc)) if (in_array($row['Field'], $column) !== false) $type[$row['Field']] = $row['Type'];
		$rslt = array();
		foreach ($column as $col) {
			$table_recov = "$table$suffix$col";
			if (!isset($type[$col]) || Db::query("SHOW TABLES like '$table_recov'")->num_rows === 1) {
				$rslt[$col] = false;
				continue;
			}
			$rslt[$col] = Db::query(
				'CREATE TABLE `' . \ScpoPHP\Config\Db::$params['database'] . '`.`' . $table_recov . '` (
					`col` ' . $type[$col] . ' NOT NULL AUTO_INCREMENT ,
					UNIQUE (`col`)
				) ENGINE = InnoDB COMMENT = \'Scpo-UserSystem：用户表\';'
			);
		}
		return $rslt;
	}
	/**
	 * MD5编码密码
	 * @param string $password 原始密码
	 * @param string $salt 盐
	 * @return array 一个数组，包含密码的MD5和盐
	 */
	static public function encode_pwd($password, $salt = null)
	{
		if (empty($salt)) $salt = bin2hex(random_bytes(8));
		return array(md5($password . hex2bin($salt)), $salt);
	}
	/**
	 * 注册账号
	 * @param array $addiinfo 账号其他信息
	 * @param string $password 账号密码
	 * @param bool $login 是否顺便登录账号
	 * @return int 账号主键
	 */
	static public function sign_up($addiinfo, $password, $login = false)
	{
		list($codedpwd, $salt) = self::encode_pwd($password);
		$addiinfo[CAcTable::$salt] = "0x$salt";
		$addiinfo[CAcTable::$password] = "0x$codedpwd";
		$identity = Db::insert($addiinfo, CAcTable::$table, true);
	}
	/**
	 * 设置cookie
	 * @param string $name cookie的名字
	 * @param string $value cookie的值
	 * @return bool 是否成功
	 */
	static public function setcookie($name, $value)
	{
		return setcookie(...Cookie::getParams(
			CAuCookie::$params,
			$name,
			$value
		));
	}
	/**
	 * 登录账号
	 * @param string $addiinfo 账号其他信息
	 * @param string $password 账号密码
	 * @param int $identity 账号主键
	 * @param bool $auth 是否进行验证
	 * @return int 错误码 1:成功 0:账号不存在 -1:密码错误
	 */
	static public function sign_in($addiinfo, $password, $identity = 0, $auth = true)
	{
		if ($auth) {
			if (
				!$acct = Db::select($addiinfo, array(
					CAcTable::$password,
					CAcTable::$salt,
					CAcTable::$identity
				), CAcTable::$table)
			) return 0;
			$codedpwd = self::encode_pwd($password, $acct[1])[0];
			if ($codedpwd !== $acct[0]) return -1;
			$identity = $acct[2];
		}
		switch (CAuth::$method) {
			case 101:
				self::setcookie(CAuCookie::$identity, $identity);
				foreach (CAuCookie::$addiinfo as $info => $name) self::setcookie($name, $info);
				break;
			case 102:
				self::setcookie(CAuCookie::$identity, $identity);
				$hash[] = $identity;
				foreach (CAuCookie::$addiinfo as $info => $name) {
					$hash[] = $info;
					self::setcookie($name, $info);
				}
				self::setcookie(CAuCookie::$authhash, CAuCookie::hash102f($hash));
				break;
			case 201:
				if (session_status() !== PHP_SESSION_ACTIVE) session_start();
				$_SESSION[CAuSession::$identity] = $identity;
				break;
		}
	}
}
