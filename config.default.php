<?php

// 全局
namespace ScpoPHP {
	/**用户配置 */
	class Config
	{
		/**默认字符编码 */
		static public $charset = 'UTF-8';
	}
}

// sql.php
namespace ScpoPHP\Config {
	/**数据库操作配置 */
	class Sql
	{
		/**主机名 */
		static public $host = 'localhost';
		/**用户名 */
		static public $name = 'root';
		/**用户密码 */
		static public $pwd = '123456';
		/**数据库 */
		static public $db = 'mysql';
		/**连接端口 */
		static public $port = 3306;
		/**socket */
		static public $socket = null;
	}
}

// email.php
namespace ScpoPHP\Config {
	/**邮件发送配置 */
	class Email
	{
		/**作为发送人显示的地址 */
		static public $addr = 'someone@163.com';
		/**作为发送人使用的名称 */
		static public $name = 'someone';
	}
}

namespace ScpoPHP\Config\Email {
	/**邮件发送SMTP服务器配置 */
	class Smtp
	{
		/**SMTP服务器地址 */
		static public $host = 'SMTP.163.com';
		/**SMTP服务器端口 */
		static public $port = 25;
		/**SMTP账号的名称 */
		static public $name = 'user';
		/**SMTP账号的密码 */
		static public $pwd = 'PASSWORD';
	}
}
