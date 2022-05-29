<?php

namespace ScpoPHP;

require_once 'config.php';
require_once 'lib/class.phpmailer.php';

class Email {
	/**
	 * 发送邮件
	 * @param string $subject 邮件主题
	 * @param string $body 邮件内容
	 * @param string|array $addr 接收人的地址
	 * @param string|array $name 接收人的名称
	 * @param bool $is_HTML 邮件格式是否是HTML
	 * @return bool|array 是否成功发送
	 */
	static public function send(
		$subject = '',
		$body = '',
		$addr = array(),
		$name = '',
		$is_HTML = true
	) {
		$config = Config::$email;
		$smtp = $config['smtp'];
		$info = $config['info'];
		$mail = new \PHPMailer();
		$mail->CharSet = Config::$charset;
		if ($is_HTML) {
			$mail->IsHTML();
			$mail->AltBody = '您的查看器不支持查看此HTML邮件！';
		}
		$mail->IsSMTP();
		$mail->Host = $smtp['host'];
		$mail->Port = $smtp['port'];
		$mail->Username = $smtp['name'];
		if ($mail->SMTPAuth = (bool)$smtp['pwd']) $mail->Password = $smtp['pwd'];
		$mail->From = $info['addr'];
		$mail->FromName = $info['name'];
		$mail->Subject = $subject;
		$mail->Body = $body;
		if (is_string($name)) $name = array($name);
		if (is_string($addr)) {
			$mail->AddAddress($addr, $name[0]);
			$rslt = $mail->Send();
		} else {
			$rslt = array();
			if (($caddr = count($addr)) > ($cname = count($name))) {
				$last_name = end($name);
				for ($i = $cname; $i < $caddr; $i++) $name[$i] = $last_name;
			}
			for ($i = 0; $i < $caddr; $i++) {
				$mail->AddAddress($addr[$i], $name[$i]);
				array_push($rslt, $mail->Send());
				$mail->ClearAllRecipients();
			}
		}
		return $rslt;
	}
}
