<?php
namespace Home\Controller;

use Think\Controller;

class SchoolController extends Controller
{
	public function _construct(){
		echo 111;
		//$this->$token = 
	}

	public function getSchoolList(){
		$m = D('Home/School');
		if(IS_POST){
			$param['name'] = I('post.name');
			$param['province'] = I('post.province');
			$param['id'] = $m->findSchool("name='{$param['name']}'");
			if(empty($param['name'])){
				$this->ajaxReturn(array('msg' => '名称不能为空','status'=> 0),'json');
			}
			if(empty($param['province'])){
				$this->ajaxReturn(array('msg' => 'CODE不能为空','status'=> 0),'json');
			}
			if(empty($param['id'])){
				$m->insertSchool($param);
				$this->ajaxReturn(array('msg' => '插入成功','status'=> 1),'json');
			}else{
				$m->gxSchool($param['id'],$param);
				$this->ajaxReturn(array('msg' => '更新成功','status'=> 1),'json');
			}
		}else{
			if(!empty(I('get.k'))){
				$k = I('get.k');
				$where = "province = '{$k}'";
			}else{
				$where = 1;
			}
			$res = $m->getSchool($where);
			$this->assign('res',$res);
			$this->display('school_list');		
		}

	}

	public function test(){
		//phpinfo();
		//import('Org.Util.Aes');
		$Aes = new \Org\Util\Aes($bit = 128, $key = 'abcdef1234567890', $iv = '0987654321fedcba', $mode = 'cbc');
		// $Aes = new \Org\Util\Aes;
		// $aes = new AESMcrypt($bit = 128, $key = 'abcdef1234567890', $iv = '0987654321fedcba', $mode = 'cbc');
		$c = $Aes->encrypt('朱毅');
		var_dump($c);echo '<br>';
		var_dump($Aes->decrypt($c));
	}

	//响应微信请求
	public function Response_Wechat(){
		//$token = I('get.token');
		//$this->error('缺少参数，非法请求',5);
		if(IS_GET){
			$weixin = new \Com\ThinkWechat('zhuyi'); //这里的TOKEN是在公众平台开发者模式中配置的TOKEN
			/* 获取请求信息 */
			$data = $weixin->request();
			/* 响应当前请求 */
			$weixin->response($content, $type);
		}else{
			$this->error('缺少参数，非法请求',5);
		}

	}













	public function wechat(){
		$wechat = new \Org\Util\Wechat;
		$url = $wechat->get_authorize_url(1);
		redirect($url,15);
	}

	public function getcode(){
		$wechat = new \Org\Util\Wechat;
		$res = $wechat->get_access_token(I('get.code'));
		print_r($res);
	}
}