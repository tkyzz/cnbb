<?php
//用户登录注册类
namespace Home\Controller;
use Think\Controller;
class UserController extends Controller {

 /**
 * @desc 构造函数
 * @author zhuyi
 * @date 2016-07-02
 */
public function __construct(){
    parent::__construct();
    $icode = I('get.icode');
	if(!empty($icode)){
		cookie('icode',$icode,1800);
	}
	
	$this->assign('browser',getUserBrowser());
    $this->assign('navclass','user');
}

 /**
 * @desc 个人注册
 * @author zhuyi
 * @date 2016-07-02
 */
public function signup(){
	if(check_login()){
		$member = session("member");
		if($member['type'] == 1){
			redirect('/index.html');
		}elseif($member['type'] == 2){
		    if($member['org_state'] == 0){
	            redirect('/company/setMail.html');
	        }elseif($member['org_state'] == 1){
	             redirect('/company/create.html');
	        }
		}   
    }
	if (IS_POST) {
		//POST参数
		$param['ip'] = getClientIp();
    	$param['account_name'] = I('post.username');
    	$param['password'] = I('post.password');
    	//$param['is_phone'] = I('post.is_phone');
    	$param['is_phone'] = 'true';
    	$param['verify_code'] = I('post.verify');
    	$param['mt'] = I('post.mt');
    	$param['device'] = 1;
    	if (empty($param['account_name']) || empty($param['password'])){
    		$this->error("请输入帐号和密码");exit;
    	}
		if (empty($param['verify_code'])){
			$this->error("请输入短信验证码");exit;
		}
		//提交注册信息
		$res = request_api(get_api_info('authorize','register'),$param,'post'); 
		// print_r($param);
		// echo get_api_info('passport','register');
		// print_r($res);
		if (!empty($res['uid'])) {
				$param['access_token'] = $res['access_token'];
				$url = get_api_info(4,$res['uid']); //获取登录路由地址
				$member = request_api($url,$param,'get'); //请求用户信息
				//print_r($member);
				session('member',$member);
				session('user',$res);
				cookie('xscnbb_token',md5($res['access_token']));
				cookie('cnbb_token',$res['access_token'],array('domain'=>C('CNBB_DOMAIN')));
				if($member['type'] == 1){
					$code = cookie('icode') ? cookie('icode') : I('post.code');
					if(!empty($code)){

						//设置邀请码
		    			$code = request_api(get_api_info('passport','set_icode'),array('access_token'=>$res['access_token'],'code'=>$code),'post'); //请求
					}
					$this->success("注册成功",'/index.html');exit;
				}
		}else {
			
			$this->error($res['error_description']);exit;
		}
	}else {
		//手机跳转到H5
	    if(is_mobile()){
	       redirect('/m/postList.html');
	    }
		$this->display("signUp");
	}
    
}

 /**
 * @desc 企业注册
 * @author zhuyi
 * @date 2016-07-02
 */
public function org_register(){
	if(check_login()){
		$member = session("member");
		if($member['type'] == 1){
			redirect(U('/index'));
		}elseif($member['type'] == 2){
		    if($member['org_state'] == 0){
	           redirect('/company/setMail');
	        }elseif($member['org_state'] == 1){
	             redirect('/company/create');
	        }
		}   
    }
	if (IS_POST) {
		//POST参数
		$param['ip'] = getClientIp();
    	$param['account_name'] = I('post.username');
    	$param['password'] = I('post.password');
    	$param['is_phone'] = I('post.is_phone') ? I('post.is_phone') : 'false';
    	//$param['is_phone'] = 'true';
    	
    	$param['mt'] = I('post.mt');
    	$param['device'] = 1;
    	if (empty($param['account_name']) || empty($param['password'])){
    		$this->error("请输入帐号和密码");exit;
    	}
    	// if(!empty($param['is_phone'])){
    	// 	$this->error("参数错误");exit;
    	// }
    	if($param['is_phone'] == 'true'){
    		$param['verify_code'] = I('post.verify');
			if (empty($param['verify_code'])){
				$this->error("请输入短信验证码");exit;
			}	
    	}else{
    		//图形验证码
    		$verify = I('post.verify_code');
			if (empty($verify)){
				$this->error("请输入图形验证码");exit;
			}
			if(!check_verify($verify)){  
			   $this->error("图形验证码错误!");exit;
			}
    	}
    	//print_r($param);

		//提交注册信息
		$res = request_api(get_api_info('authorize','register'),$param,'post'); 
		// print_r($param);
		// echo get_api_info('passport','register');
		// print_r($res);
		if (!empty($res['uid'])) {
			if($param['is_phone'] == 'true'){
				// $url = get_api_info(4,$res['uid']); //获取登录路由地址
				// $member = request_api($url,$param,'get'); //请求用户信息
				session('member',$member);
				session('user',$res);
				cookie('xscnbb_token',md5($res['access_token']));
				cookie('reg_phone',$param['account_name']);//注册手机号
				$this->success("注册成功",U('/company/setMail'));exit;
				//cookie('cnbb_token',$res['access_token'],'domain=.cainiaobangbang.com');
			}else{
				session('email',$param['account_name']);

				$this->success("注册成功",U('/registerActive'));exit;
			}

				// if($member['type'] == 1){
				// 	$code = cookie('icode') ? cookie('icode') : I('post.code');
				// 	if(!empty($code)){

				// 		//设置邀请码
		  //   			$code = request_api(get_api_info('passport','set_icode'),array('access_token'=>$res['access_token'],'code'=>$code),'post'); //请求
				// 	}
				// 	$this->success("注册成功",U('/index'));exit;
				// }elseif($member['type'] == 2){

					
				// }
				
		}else {
			
			$this->error($res['error_description']);exit;
		}
	}else {
		//手机跳转到H5
	    if(is_mobile()){
	       redirect('/m/postList.html');
	    }
		$this->display("companyRegister");
	}
    
}


 /**
 * @desc 验证码
 * @author zhuyi
 * @date 2016-07-02
 */
public function verifyImg(){
	$Verify = new \Think\Verify();
	//$Verify->useImgBg = true; 
	$Verify->fontSize = 18;  
    $Verify->length   = 4;  
    //$Verify->useNoise = true;  
    $Verify->codeSet = '0123456789';
    $Verify->imageW = 120;  
    $Verify->imageH = 34; 
	$Verify->entry();
}

/**
 * @desc ajax验证验证码
 * @author zhuyi
 * @date 2016-09-22
 */
public function check_verify_code(){
	$verify = I('param.verify','');  
	if(!check_verify($verify)){  
	    $this->ajaxReturn(array('msg' => 验证码错误,'status'=> 0),'json');
	} else{
		$this->ajaxReturn(array('msg' => 'verify_pass','status'=> 1),'json');
	}
}

/**
 * @desc 企业登录
 * @author zhuyi
 * @date 2016-07-02
 */
public function org_login(){

	if(check_login()){
		$member = session("member");
		if($member['type'] == 1){
			session(null);
    		cookie('xscnbb_token',null);
			//$this->redirect('/index');
		}elseif($member['type'] == 2){
		    if($member['org_state'] == 0){
	            redirect('/company/setMail');
	        }elseif($member['org_state'] == 1){
	            redirect('/company/create');
	        }
		}   
    }
	if(cookie("cnbb_token")){
		redirect(C('EE_URL'));
	}
    if (IS_POST) {
    	$param['ip'] = getClientIp();
    	$param['account_name'] = I('post.phone');
    	$param['password'] = I('post.password');
		$param['device'] = 1;
		$return = urldecode(I('post.return'));
		$is_keep = I('post.is_keep');
		//$return_url = urldecode(I('post.return_url'));
		if (empty($param['account_name']) || empty($param['password'])){
    		$this->ajaxReturn(array('msg'=>'请输入用户名和密码','status'=>0),'json');
    	}
		$res = request_api(get_api_info(0,'login'),$param,'post'); //请求
		if(isset($res['un_events']) && $res['un_events'][0] == 'unverified_mail'){
    	//激活邮箱才能使用某些功能
    		session('email',$param['account_name']);
        	$data['url'] =  U('/registerActive');
			$data['status'] = 1;
			$data['msg'] = "操作成功";
			$this->ajaxReturn($data,'json');
			exit;
    	}
		//echo $res['access_token'];
		if (!empty($res['access_token'])) {
			//记住密码
			// if($is_keep){
			// 	cookie('company',$param['account_name'],3600*24*7);
			// 	cookie('company2',$param['password'],3600*24*7);
			// }else{
			// 	cookie('company',null);
			// 	cookie('company2',null);
			// }
			$res['account_name'] = $param['account_name'];//用户名
			$member = request_api(get_api_info(4,$res['uid']),array('access_token'=>$res['access_token']),'get');
			//print_r($member);

			//session('email','zhuyi@qq.com');
			 //请求
			if($member['type'] ==2 ){
				//验证机构状态
				$org_state = request_api(get_api_info('org','verify_state'),array('access_token'=>$res['access_token']),'get'); 
				$member['org_state'] = $org_state['result'];
				//cookie('cnbb_token',$res['access_token']);
				//echo $res['access_token'];

				
				//机构0、未设置联系邮箱 1、未创建 2、审核通过或审核中 3、审核失败
				//print_r($org_state);
				//调试模式
				if(I('get.mode') == 'test'){
					print_r($org_state);
				}
				switch ($member['org_state']) {
					case '0':
						cookie('xscnbb_token',md5($res['access_token']));
						session('user',$res);
						session('member',$member);	
						$data['url'] = U('/company/setMail');
						break;
					case '1':
						cookie('xscnbb_token',md5($res['access_token']));
						session('user',$res);
						session('member',$member);	
						$data['url'] = U('/company/create');
						break;
					case '2':

					case '3':
						if(!empty($is_keep)){
							cookie('cnbb_token',$res['access_token'],array('expire'=>3600*24*30,'domain'=>C('CNBB_DOMAIN')));
						}else{
							cookie('cnbb_token',$res['access_token'],array('domain'=>C('CNBB_DOMAIN')));
						}
						$data['url'] = C('EE_URL');
						break;
					case '5':
						cookie('xscnbb_token',md5($res['access_token']));
						session('user',$res);
						session('member',$member);
						session('email',$org_state['error_description']);
						$data['url'] = U('/company/authlxMail');
						break;
					case '6':
					case '7':
						if(!empty($is_keep)){
							cookie('cnbb_token',$res['access_token'],array('expire'=>3600*24*30,'domain'=>C('CNBB_DOMAIN')));
						}else{
							cookie('cnbb_token',$res['access_token'],array('domain'=>C('CNBB_DOMAIN')));
						}
						$data['url'] = C('EE_URL');
						break;
					default:
						$this->ajaxReturn(array('msg'=>'此账号存在异常,请联系客服~','status'=>0),'json');
						break;
				}
				$data['status'] = 1;
				$data['msg'] = "操作成功";
				$this->ajaxReturn($data,'json');
			}elseif($member['type'] ==1){
				$data['status'] = 0;
				$data['msg'] = "登录失败:学生账户无法登录！";
				$this->ajaxReturn($data,'json');
			}
		}else{
				$this->ajaxReturn(array('msg'=>$res['error_description'],'status'=>0),'json');
			 }
	}else{
			//手机跳转到H5
		    if(is_mobile()){
		       redirect('/m/postList.html');
		    }
			$this->display("companyLogin");
	}

}

/**
 * @desc 学生登录
 * @author zhuyi
 * @date 2016-07-02
 */
public function login(){
	if(check_login()){
		$member = session("member");
		if($member['type'] == 1){
			redirect('/index.html');
		}elseif($member['type'] == 2){
		    if($member['org_state'] == 0){
	            redirect('/company/setMail.html');
	        }elseif($member['org_state'] == 1){
	             redirect('/company/create.html');
	        }
		}   
    }
	if (IS_POST) {
		$param['ip'] = getClientIp();
    	$param['account_name'] = I('post.username');
    	$param['password'] = I('post.password');
		$param['device'] = 1;
		$return = I('post.return_url');
		$is_keep = I('post.is_keep');
		//$return_url = urldecode(I('post.return_url'));
		if (empty($param['account_name']) || empty($param['password'])){
    		$this->error("请输入帐号和密码");exit;
    	}
		$res = request_api(get_api_info(0,'login'),$param,'post'); //请求

		if(isset($res['un_events']) && $res['un_events'][0] == 'unverified_mail'){
    	//激活邮箱才能使用某些功能
    		session('email',$param['account_name']);
        	$data['url'] =  U('/registerActive');
			$data['status'] = 1;
			$data['msg'] = "操作成功";
			$this->ajaxReturn($data,'json');
			exit;
    	}
		if (!empty($res['access_token'])) {
			//记住密码
			if($is_keep){
				cookie('stu',$param['account_name'],3600*24*7);
				cookie('stu2',$param['password'],3600*24*7);
			}else{
				cookie('stu',null);
				cookie('stu2',null);
			}
			$res['account_name'] = $param['account_name'];//用户名
			$member = request_api(get_api_info(4,$res['uid']),array('access_token'=>$res['access_token']),'get'); //请求
			//print_r($res);
			if($member['type'] ==2 ){
				//验证机构状态
				$org_state = request_api(get_api_info('org','verify_state'),array('access_token'=>$res['access_token']),'get'); 
				$member['org_state'] = $org_state['result'];
				//cookie('cnbb_token',$res['access_token']);
				//echo $res['access_token'];
				//机构0、未设置联系邮箱 1、未创建 2、审核通过或审核中 3、审核失败
				//调试模式
				if(I('get.mode') == 'test'){
					print_r($org_state);
				}
				switch ($member['org_state']) {
					case '0':
						cookie('xscnbb_token',md5($res['access_token']));
						session('user',$res);
						session('member',$member);	
						$data['url'] = U('/company/setMail');
						break;
					case '1':
						cookie('xscnbb_token',md5($res['access_token']));
						session('user',$res);
						session('member',$member);	
						$data['url'] = U('/company/create');
						break;
					case '2':
						$data['url'] = C('EE_URL');
						cookie('cnbb_token',$res['access_token'],array('expire'=>3600*24*30,'domain'=>C('CNBB_DOMAIN')));
						break;
					// case '3':
					// 	$data['url'] = U('/company/resub');
					// 	break;
					// case '5':
					// 	session('email',$org_state['error_description']);
					// 	$data['url'] = U('/company/authlxMail');
					// 	break;
					default:
						$this->ajaxReturn(array('msg'=>'此账号存在异常','status'=>0),'json');
						break;
				}
				$data['status'] = 1;
				$data['msg'] = "操作成功";
				$this->ajaxReturn($data,'json');
			}elseif($member['type'] ==1){
					cookie('xscnbb_token',md5($res['access_token']));
					session('user',$res);
					//消息数量
					session('message_num',_get_notice());
					session('member',$member);
					session('op_time',time());
					if(!empty($return)){
						$this->ajaxReturn(array('msg'=>'success','url'=>$return,'status'=>1),'json');	
					}else{
						$this->ajaxReturn(array('msg'=>'success','url'=>'/index.html','status'=>1),'json');
					}		
			}
		}else{
			$this->ajaxReturn(array('msg'=>$res['error_description'],'status'=>0),'json');	
			 }
	}else{
			//手机跳转到H5
		    if(is_mobile()){
		       redirect('/m/postList.html');
		    }
			$this->display("login");
	}
    
}

 /**
 * @desc 验证邮箱
 * @author zhuyi
 * @date 2016-07-02
 */
public function Active_Email()
{
	//手机跳转到H5
    if(is_mobile()){
       redirect('/m/notice/orgAuth.html');
    }
	if(I('get.code') && I('get.time')){
		$param['code'] = I('get.code');
		$param['time'] = I('get.time');
		$param['device'] = 1;
		if (empty($param['code']) || empty($param['time'])){
			$this->error(U('index'));
		}
		$url = get_api_info(0,'verify_email'); //获取登录路由地址
		$res = request_api($url,$param,'post'); //请求
		if (!empty($res['access_token'])){
			$res['account_name'] = $param['account_name'];//用户名
			$url = get_api_info(4,$res['uid']); //获取登录路由地址
			$member = request_api($url,$param,'get'); //请求
			//验证机构状态
			$org_state = request_api(get_api_info('org','verify_state'),array('access_token'=>$res['access_token']),'get'); 
			$member['org_state'] = $org_state['result'];
			cookie('xscnbb_token',md5($res['access_token']));
			session('user',$res);
			session('member',$member);
			redirect(U('/company/create'), 1, '激活成功......');
			// if($member['type'] ==1){
			// 	redirect(U('/index'), 1, '激活成功......');
			// }else{
				
			// 	$param['access_token'] = $res['access_token'];
	  //   		$url = get_api_info('org','verify_state'); //获取登录路由地址
			// 	$res = request_api($url,$param,'get'); //验证企业联系邮箱状态
				
			// 	if($res['result'] == 0){
			// 		redirect(U('/company/setMail'), 1, '企业账号激活成功......');
			// 	}else{
			// 		redirect(U('/index'), 1, '出现错误...请重试');
			// 	}
				
			// }
			
		}else{
			redirect(U('/authFail'), 1, '验证失败......');
			//$this->display("reVerify_sign");
		}
	}elseif(session('email')){
		$this->assign('tips','重新填写邮箱注册');
		$this->assign('url','/hrRegister.html');
		$this->assign('p_url','/reSendEmail.html');
		$this->display("/company/register-mail");
	}else{
        $this->error("出现错误");
    }
	  
}

 /**
 * @desc 发送手机验证码
 * @author zhuyi
 * @date 2016-07-02
 */
public function Send_Phone_Verifycode()
{
    if (IS_POST) {
    	$type = I('param.type','');
    	if (!in_array($type,array('register','reset_pwd'))){
    		$this->ajaxReturn(array('msg' => '参数错误','status'=> 0),'json');
    	}
    	$verify = I('param.verify','');  
		if(!check_verify($verify)){  
		    $this->ajaxReturn(array('msg' => '验证码错误','status'=> 0),'json');
		}
    	$param['ip'] = getClientIp();
    	$param['phone'] = I('post.phone');
    	$param['usage'] = I('post.usage');
		$url = get_api_info(0,'send_phone_verifycode'); //获取登录路由地址
		$res = request_api($url,$param,'post'); //请求
		if (empty($res['phone_no'])) {
			$this->ajaxReturn(array('msg' => $res['error_description'],'status'=> 0),'json');
		}else {
			$this->ajaxReturn(array('msg' => '发送成功','status'=> 1),'json');
		}
		
	}

}


 /**
 * @desc 邮箱找回密码
 * @author zhuyi
 * @date 2016-07-02
 */
public function Mail_Verify()
{
	if(check_login()){
       redirect(U('/index'));
    }
    if (IS_POST) {
    	$param['email'] = I('post.email');
		$url = get_api_info(0,'send_find_password_email'); //获取登录路由地址
		$res = request_api($url,$param,'post'); //请求
		if ($res['error'] == 'success') {
			$this->success("发送成功");exit;
		}else {
			$this->error($res['error_description']);exit;
		}
		
	}else{
		//手机跳转到H5
	    if(is_mobile()){
	       redirect('/m/postList.html');
	    }
		$this->display('mailVerify');
	}

}

 /**
 * @desc 验证找回密码邮箱
 * @author zhuyi
 * @date 2016-07-02
 */
public function Auth_Email()
{
	$param['uid'] = I('get.uid');
	$param['code'] = I('get.code');
	$param['time'] = I('get.time');
	$param['new_password'] = I('get.pwd');
	if ($param['uid'] && $param['code'] && $param['time'] && !$param['new_password']){
		$this->display('getPassword_mail');
	}
	if (!empty($param['new_password'])){
    	$url = get_api_info(0,'reset_password_from_email'); //获取登录路由地址
		$res = request_api($url,$param,'post'); //请求
    	if ($res['error_code'] == 'success') {
				$this->ajaxReturn(array('msg' => "修改成功！",'status'=> 1),'json');
			}else {
				$this->ajaxReturn(array('msg' => $res['error_description'],'status'=> 0),'json');
		}
	}	
}

 /**
 * @desc 验证失败过期
 * @author zhuyi
 * @date 2016-07-02
 */
public function Auth_Fail()
{
	if(check_login()){
       redirect(U('/index'));
    }
	//手机跳转到H5
    if(is_mobile()){
       redirect('/m/postList.html');
    }
	$this->display('register-authfail');
    	
}

/**
 * 验证失败/过期
 */
public function Re_Auth_Email()
{
	if(check_login()){
       redirect(U('/index'));
    }
	if(IS_POST){
		$param['email'] = I('post.email');
		$url = get_api_info(0,'resend_email_verifycode'); //获取登录路由地址
		$res = request_api($url,$param,'post'); //请求重新发送邮件
    	if ($res['error_code'] == 'success') {
    			session('email',$param['email']);
				$this->ajaxReturn(array('msg' => "发送成功",'status'=> 1),'json');
			}else {
				$this->ajaxReturn(array('msg' => $res['error_description'],'status'=> 0),'json');
			}
	}else{
		//手机跳转到H5
	    if(is_mobile()){
	       redirect('/m/postList.html');
	    }
		$this->display('reVerify_sign');
	}		
    	
}

/**
 * 验证手机验证码
 */
public function Auth_Phone_Code()
{
	$param['phone'] = I('post.phone');
	$param['code'] = I('post.code');
	$param['usage'] = I('post.usage');
	$url = get_api_info('authorize','verify_code'); //获取登录路由地址
	$res = request_api($url,$param,'post'); //验证手机验证码
	if ($res['error_code'] == 'success') {
			$this->ajaxReturn(array('msg' => "手机验证码有效",'status'=> 1),'json');
		}else {
			$this->ajaxReturn(array('msg' => $res['error_description'],'status'=> 0),'json');
		}
	
    	
}

 /**
 * @desc 手机找回密码
 * @author zhuyi
 * @date 2016-07-02
 */
public function Phone_Verify()
{
	//手机跳转到H5
    if(is_mobile()){
       redirect('/m/postList.html');
    }
    if (IS_POST) {
    	$param['phone'] = I('post.phone');
    	$param['new_password'] = I('post.password');
    	$param['verify_code'] = I('post.code');
    	if (empty($param['phone'])){
    		$this->error("请输入帐号");exit;
    	}
    	if(!preg_match("/^1[3458][0-9]{9}$/",$param['phone'])){
    		$this->error("请输入正确的手机号");exit;
		}
    	if (empty($param['new_password'])){
    		$this->error("密码不能为空");exit;
    	}
    	if (empty($param['verify_code'])){
    		$this->error("请输入短信验证码");exit;
    	}
		$url = get_api_info(0,'reset_password_usephone'); //获取登录路由地址
		$res = request_api($url,$param,'post'); //请求
		if ($res['error_code'] == 'success') {
			$this->success("修改成功",U('/login'));exit;
		}else {
			$this->error($res['error_description']);exit;
		}
		
	}else{
		if(I('get.t') == 'company'){
			$this->assign('type','company');
			$this->display('phoneVerify_company');
		}else{
			$this->assign('type','student');
			$this->display('phoneVerify');
		}
	}

}

 /**
 * @desc 重新发送邮件
 * @author zhuyi
 * @date 2016-07-02
 */
public function Re_Send_Email(){
	$param['email'] = I('post.email');
	if(empty($param['email'])){
		$this->ajaxReturn(array('msg' => '参数错误','status'=> 0),'json');
	}
	$url = get_api_info('authorize','resend_email_verifycode'); //获取登录路由地址
	$res = request_api($url,$param,'post'); //重新发送邮箱验证
	//print_r($res);
	if ($res['error_code']!='success'){
		$this->ajaxReturn(array('msg' => $res['error_description'],'status'=> 0),'json');
	}else{
			$data['msg'] = "重新发送到".$param['email']."成功！";
			$data['status'] =1;
			$data['info'] = $res;
			$this->ajaxReturn($data,'json');
	}    
}






















}