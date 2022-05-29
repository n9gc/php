<?php

namespace ScpoPHP;

class Config {
	/**默认字符编码 */
	static public $charset = 'UTF-8';
	/**数据库连接配置 */
	static public $sql = array(
		// 主机名
		'hostname' => 'localhost',
		// 用户名
		'username' => 'root',
		// 用户密码
		'password' => '123456',
		// 数据库
		'database' => 'mysql',
		// 连接端口
		'port' => 3306,
		// socket
		'socket' => null
	);
	static public $email = array(
		// SMTP服务器连接配置
		'smtp' => array(
			// SMTP服务器地址
			'host' => 'SMTP.163.com',
			// SMTP服务器端口
			'port' => 25,
			// SMTP账号的名称
			'name' => 'user',
			// SMTP账号的密码
			'pwd' => 'PASSWORD'
		),
		// 邮件信息
		'info' => array(
			// 发送人的地址
			'addr' => 'someone@163.com',
			// 发送人的名称
			'name' => 'someone',
		)
	);
}
