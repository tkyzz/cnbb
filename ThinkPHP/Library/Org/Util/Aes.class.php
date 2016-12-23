<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2009 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

namespace Org\Util;
/**
 * AES操作类
 * @category   ORG
 * @package  ORG
 * @subpackage  AES
 * @author    zhuyi <zhuyi@gmail.com>
 * @version   $Id: Aes.class.php 2662 2016-11-14 06:32:50Z $
 */
class Aes {

	public $iv = null;
	public $key = null;
	public $bit = 128;
	private $cipher;

	/**
     * 构造函数
     * @var integer
     * @access public
     */
	public function __construct($bit, $key, $iv, $mode) {

		 if(empty($bit) || empty($key) || empty($iv) || empty($mode))
			 return NULL;

		 $this->bit = $bit;
		 $this->key = $key;
		 $this->iv = $iv;
		 $this->mode = $mode;
		 
		 switch($this->bit) {
		  case 192:$this->cipher = MCRYPT_RIJNDAEL_192; break;
		  case 256:$this->cipher = MCRYPT_RIJNDAEL_256; break;
		  default: $this->cipher = MCRYPT_RIJNDAEL_128;
		 }

		 switch($this->mode) {
		  case 'ecb':$this->mode = MCRYPT_MODE_ECB; break;
		  case 'cfb':$this->mode = MCRYPT_MODE_CFB; break;
		  case 'ofb':$this->mode = MCRYPT_MODE_OFB; break;
		  case 'nofb':$this->mode = MCRYPT_MODE_NOFB; break;
		  default: $this->mode = MCRYPT_MODE_CBC;
		 }

	}

    /**
     * Aes加密
     * @var integer
     * @access public
     */
	public function encrypt($data) {
	 $data = base64_encode(mcrypt_encrypt( $this->cipher, $this->key, $data, $this->mode, $this->iv));
	 return $data;

	}

    /**
     * Aes解密
     * @var integer
     * @access public
     */
	public function decrypt($data) {

	 $data = mcrypt_decrypt( $this->cipher, $this->key, base64_decode($data), $this->mode, $this->iv);
	 $data = rtrim(rtrim($data), "\x00..\x1F");
	 return $data;

	}

}