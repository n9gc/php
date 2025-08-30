<?php

// 全局
namespace ScpoPHP\Config {
	/**基本配置 */
	class Base
	{
		public static Self $now;
		public function __construct(
			/**默认字符编码 */
			public $charset = 'UTF-8',
		) {
			Self::$now = $this;
		}
	}
	new Base();
}

// db.php
namespace ScpoPHP\Config {
	/**数据库操作配置 */
	class Db
	{
		public static Self $now;
		public function __construct(
			/**连接参数 */
			public $params = [
				'hostname' => 'localhost',
				'username' => 'root',
				'password' => '123456',
				'database' => 'mysql',
				'port' => 3306,
				'socket' => null
			],
		) {
			Self::$now = $this;
		}
	}
	new Db();
}

// cookie.php
namespace ScpoPHP\Config {
	/**cookie简便函数相关 */
	class Cookie
	{
		public static Self $now;
		public function __construct(
			/**setcookie默认参数 */
			public $params = [
				'value' => '',
				'expires_or_options' => 0,
				'path' => '',
				'domain' => '',
				'secure' => false,
				'httponly' => false
			],
		) {
			Self::$now = $this;
		}
	}
	new Cookie();
}

// captcha.php
namespace ScpoPHP\Config {
	/**验证码配置 */
	class Captcha
	{
		/**图片宽 */
		static public $width = 150;
		/**图片高 */
		static public $height = 45;
	}
}

// user.php
namespace ScpoPHP\Config {
	/**用户系统配置 */
	class User {}
}

namespace ScpoPHP\Config\User {
	/**账号数据表相关 */
	class Acct {}
}

namespace ScpoPHP\Config\User\Acct {
	/**账号数据表配置 */
	class Table
	{
		/**账号数据表名称 */
		static public $table = 'scpous_account';
		/**主键字段名称 */
		static public $identity = 'id';
		/**密码字段名称 */
		static public $password = 'password';
		/**盐字段名称 */
		static public $salt = 'salt';
		/**其他字段 */
		static public $addiinfo = array(
			'username'
		);
	}
}

namespace ScpoPHP\Config\User\Acct\Table {
	/**唯一索引复用相关配置
	 * @link http://scpo-php.seventop.top/user/acct/recov/ */
	class Recov
	{
		/**是否启用复用 */
		static public $enable = true;
		/**复用字段 */
		static public $column = array(
			'id'
		);
		/**复用表后缀 则复用表名称为"${table_name}${suffix}${column_name}" */
		static public $suffix = '_recov_';
	}
}

namespace ScpoPHP\Config\User {
	/**账号验证相关 */
	class Auth
	{
		/**账号验证的方法
		 * @link http://scpo-php.seventop.top/user/method/ */
		static public $method = 102;
	}
}

namespace ScpoPHP\Config\User\Auth {
	/**账号验证cookie相关 */
	class Cookie
	{
		/**存储密码的字段名 */
		static public $password = 'scpous-password';
		/**存储主键的字段名 */
		static public $identity = 'scpous-identity';
		/**存储验证哈希的字段名 */
		static public $authhash = 'scpous-authhash';
		/**其他信息的字段名 */
		static public $addiinfo = array(
			'username' => 'scpous-username'
		);
		/**默认参数 */
		static public $params = array(
			'expires_or_options' => 3600 * 24 * 15,
			'path' => '/',
			'domain' => '',
			'secure' => false,
			'httponly' => false
		);
		/**
		 * 102号方法的哈希函数
		 *
		 * 默认函数仅为示例，
		 * 为了安全性请您重写此函数或者修改闭包函数`ScpoPHP\Config\User\Auth\Cookie::$my_hash102f`
		 * @param array $orig 应有一个参数接受要加密的信息的数组
		 * @return string 应返回哈希后得到的字符串
		 */
		static public function hash102f($orig)
		{
			if (($myf = self::$my_hash102f) !== false) return $myf($orig);
			// 加盐
			$str = hex2bin('C843906F02510E8C87ED9667F0525D689F1CF74F9A1594A5');
			// 哈希
			foreach ($orig as $val) $str .= $val;
			return md5($str);
		}
		/**用户自定义102号方法哈希函数 */
		static public $my_hash102f = false;
	}
	/**账号验证session相关 */
	class Session
	{
		/**存储id的字段名 */
		static public $identity = 'scpous-identity';
	}
}

// email.php
namespace ScpoPHP\Config {
	/**邮件发送SMTP服务器配置 */
	class Smtp
	{
		public function __construct(
			/**SMTP服务器地址 */
			public $host = 'SMTP.163.com',
			/**SMTP服务器端口 */
			public $port = 25,
			/**SMTP账号的名称 */
			public $name = 'user',
			/**SMTP账号的密码 */
			public $pwd = 'PASSWORD',
		) {}
	}
	/**邮件发送配置 */
	class Email
	{
		public static Self $now;
		public function __construct(
			public $smtp = new Smtp(),
			/**作为发送人显示的地址 */
			public $addr = 'someone@163.com',
			/**作为发送人使用的名称 */
			public $name = 'someone',
		) {
			Self::$now = $this;
		}
	}
	new Email();
}
