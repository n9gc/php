<?php

namespace ScpoPHP;

/**
 * ScpoAPI实现函数
 * @link http://scpo-php.seventop.top/api/
 */
class Api {
	/**
	 * 打包api数据
	 * @param array $data 数据
	 * @return string api的json
	 */
	static public function pack($data)
	{
		return json_encode(array(
			'code' => $data ? 0 : -1,
			'info' => $data ? 'success' : 'no data',
			'time' => date('Y-m-d H:i:s'),
			'data' => $data,
		));
	}
}
