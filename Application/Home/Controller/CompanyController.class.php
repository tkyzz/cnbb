<?php
//author zhuyi
namespace Home\Controller;
use Think\Controller;
class CompanyController extends Controller {

    public function __construct(){
        parent::__construct();
        $this->assign('navclass','company');
    }




    /**
     * @desc 设置公司联系邮箱
     * @author zhuyi
     * @date 2016-09-02
     */
    public function Set_Contacter_Mail(){
    	if(IS_POST){
	    	$param['access_token'] = session('user.access_token');
	    	$param['email'] = I('post.email');

	    	if (empty($param['access_token']) || empty($param['email'])){
	    		$this->ajaxReturn(array('msg' => '参数错误','status'=> 0),'json');
	    	}
	    	$url = get_api_info('org','set_contact_email'); //获取API地址
			$res = request_api($url,$param,'post'); //提交
	    	if ($res['result'] == 0) {
                     $this->ajaxReturn(array('msg' => $res['error_description'],'status'=> 0),'json');
			}elseif($res['result'] == 1) {
                    session('email',$param['email']);
					$this->ajaxReturn(array('msg' => "发送成功！",'status'=> 1),'json');
			}elseif($res['result'] == 2){
                    $this->ajaxReturn(array('msg' => "无需验证！",'status'=> 2),'json');
            }
    	}else{
            //手机跳转到H5
            if(is_mobile()){
               redirect('/m/postList.html');
            }
    		$this->display('register-phone');
    	}

    }

    /**
     * @desc 创建公司
     * @author zhuyi
     * @date 2016-09-01
     */
    public function Create_Company_Basic(){
        // if(!($type == 'create' || $type == 'resub')){
        //     $this->ajaxReturn(array('msg' => '非法操作！','status'=> 0),'json');
        // }
        if(IS_POST){
            $param['access_token'] = session('user.access_token');
            //$param['access_token'] ='OWRuc1lTcW9EcklhVGVFR1hEcWhqUT09_A_6f1ecc5730';
            if(empty($param['access_token'])){
               $this->ajaxReturn(array('msg' => '你还没有登录！','status'=> 0),'json');
            }

            $param['fullname'] = I('post.fullname');//公司全称
            $param['abbrname'] = I('post.abbrname');//公司简称
            $param['trade'] = I('post.trade');//一级行业
            $param['subtrade'] = I('post.subtrade');//二级行业
            $param['nature'] = I('post.nature');//公司性质
            $param['province'] = I('post.province');//省
            $param['city'] = I('post.city');//市
            $param['addr'] = I('post.addr');//详细地址
            $param['remark'] = I('post.remark');//公司简介
            $param['tags'] = I('post.tags');//岗位亮点标签
            //print_r($param);
            //去除没有内容的变量
            foreach($param as $k => $v){
                if($param[$k] == ''){
                    unset($param[$k]);
                }
            }
            $url = get_api_info('org','create'); //获取创建机构API地址
            $res = request_api($url,$param,'post'); //提交
            if ($res['error_code'] == 'success') {
                    $this->ajaxReturn(array('type'=>$type,'msg' => "创建机构成功！",'status'=> 1,'url' => '/company/extra.html?id='.$res['result']),'json');
                }else {
                    $this->ajaxReturn(array('msg' => $res['error_description'],'status'=> 0),'json');
                }
        }else{
           if(!check_login()){
               $this->error('请登录','/hrLogin.html',2);
            }
            //手机跳转到H5
            if(is_mobile()){
               redirect('/m/postList.html');
            }
            $area = smartAreas(array('code' => "",'nohw'=>'true'));//省列表
            $this->assign('area',$area);
            $trades = smartTrades();//行业
            $this->assign('trades',$trades);
            $company_type = Dicts(2);//公司性质
            $this->assign('company_type',$company_type);
            //$token = Q0NKNVNwbi9qdXQ0bjZyZFFVV0E0dz09_A_20ce7e6a27;
            if(I('get.mode')=='test'){
                print_r(session('user'));
                print_r($tag_list);

            }
            $tag_list = smartTag(array('access_token'=>session('user.access_token')));//亮点标签
           // $tag_list = smartTag(array('access_token'=>$token));//亮点标签
            //print_r($tag_list);
            $this->assign('tag_list',$tag_list);
            $this->display('company-basicInfo');
        }
    }


    /**
     * @desc 填写额外的企业信息
     * @author zhuyi
     * @date 2016-10-21
     */
    public function Create_Company_Extra(){
       if(!check_login()){
           $this->error('请登录','/hrLogin.html',2);
        }
        //手机跳转到H5
        if(is_mobile()){
           redirect('/m/postList.html');
        }
        if(IS_POST){
            $param['access_token'] = session('user.access_token');
            if(empty($param['access_token'])){
               $this->ajaxReturn(array('msg' => '你还没有登录！','status'=> 0),'json');
            }
            $param['id'] = I('post.id');
            if(empty($param['id'])){
               $this->ajaxReturn(array('msg' => '参数错误','status'=> 0),'json');
            }
            $param['contacter'] = I('post.contacter');//联系人
            $param['contacter_mail'] = I('post.contacter_mail');//联系人邮箱
            $param['contacter_phone'] = I('post.contacter_phone');//联系座机
            $param['contacter_mobile'] = I('post.contacter_mobile');//联系手机号
            $param['yyzz_img'] = I('post.yyzz_img');//营业执照
            //去除没有内容的变量
            foreach($param as $k => $v){
                if(!isset($param[$k]) || $param[$k] == 'no'){
                    unset($param[$k]);
                }
            }
            //print_r($param);
            $url = get_api_info('org','update'); //获取创建机构API地址
            $res = request_api($url,$param,'put'); //更新机构信息提交
            //print_r($res);
            if ($res['error_code'] == 'success') {
           // $this->ajaxReturn(array('msg' => "操作成功！",'status'=> 1,'url' => 'http://b.cainiaobangbang.com/Info/Index/index'),'json');
            cookie('cnbb_token',session('user.access_token'),array('expire'=>3600*24*30,'domain'=>C('CNBB_DOMAIN')));
            $this->ajaxReturn(array('msg' => "操作成功！",'status'=> 1,'url' => C('EE_URL')),'json');
                }else {
                    $this->ajaxReturn(array('msg' => $res['error_description'],'status'=> 0),'json');
                }
        }else{
            $is_orgemail = $this->_check_org_email(session('user.access_token'));
            //$
            //print_r($is_orgemail);
            $this->assign('is_orgemail',$is_orgemail);
            $this->display('company-touchInfo');
        }
        
    }


    /**
     * @desc 创建公司
     * @author zhuyi
     * @date 2016-09-01
     */
    public function Create_Company_Basic_bak(){
        // if(!($type == 'create' || $type == 'resub')){
        //     $this->ajaxReturn(array('msg' => '非法操作！','status'=> 0),'json');
        // }
    	if(IS_POST){
    		$param['access_token'] = session('user.access_token');
            if(empty($param['access_token'])){
               $this->ajaxReturn(array('msg' => '你还没有登录！','status'=> 0),'json');
            }
            $imginfo = $this->upload($_FILES,"logo");
            //print_r($_FILES['yyzz']);
		    $file_yyzz = $_FILES['yyzz']['tmp_name'];
            $file_other = $_FILES['other']['tmp_name'];
            $path = $_SERVER['DOCUMENT_ROOT'].'/uploads/';
            $url = get_api_info("file",'upload'); //获取路由地址
            if(!empty($file_yyzz)){
                if($_FILES['yyzz']['size']>5*1024*1024){
                    $this->ajaxReturn(array('msg' => '图片太大了，最大5MB','status'=> 0),'json');
                }
                $name = date("YmdHis").rand(1,1000).'.'.pathinfo($_FILES['yyzz']['name'], PATHINFO_EXTENSION);
                //move_uploaded_file($_FILES['yyzz']['tmp_name'],$path.$_FILES['yyzz']['name']);
                move_uploaded_file($_FILES['yyzz']['tmp_name'],$path.$name);
                $file1 = $path.$name;//营业执照
                $param['filename'] = $name;
                $param['file'] = curl_file_create($file1);
                $res1 = request_api($url,$param,'post'); //上传
                if(empty($res1['file_id'])){
                    $this->ajaxReturn(array('msg' => '图片上传失败','status'=> 0),'json');
                }else{
                    $param['yyzz_img'] = $res1['file_id'];//营业执照pic_id
                }
            }
            if(!empty($file_other)){
                if($_FILES['other']['size']>5*1024*1024){
                    $this->ajaxReturn(array('msg' => '图片太大了，最大5MB','status'=> 0),'json');
                }
                $name = date("YmdHis").rand(1,1000).'.'.pathinfo($_FILES['other']['name'], PATHINFO_EXTENSION);
                move_uploaded_file($_FILES['other']['tmp_name'],$path.$name);
                $file2 = $path.$name;//其他
                $param['filename'] = $name;
                $param['file'] = curl_file_create($file2);
                $res2 = request_api($url,$param,'post'); //上传
                if(empty($res2['file_id'])){
                    $this->ajaxReturn(array('msg' => '图片上传失败','status'=> 0),'json');
                }else{
                    $param['ex1'] = $res2['file_id'];//营业执照pic_id
                }
            }
    		$param['fullname'] = I('post.name');//公司全称
    		$param['contacter'] = I('post.contacter');//联系人
    		$param['contacter_job'] = I('post.job');//联系人职务
    		$param['contacter_department'] = I('post.department');//联系人部门
    		$param['contacter_mail'] = I('post.contacter_mail');//联系人邮箱
    		$param['contacter_mobile'] = I('post.mobile');//联系人手机
    		$param['contacter_phone'] = I('post.tel');//公司座机
    		$param['ex2'] = I('post.product_type');//产品类型,体验版/基础版

            $url = get_api_info('org','create'); //获取创建机构API地址
            $res = request_api($url,$param,'post'); //提交
            // if (I("get.type") == 'create'){

            // }elseif (I("get.type") == 'resub'){
            //     $url = get_api_info('org','resubmit'); //获取重新提交机构API地址
            //     $res = request_api($url,$param,'put'); //重新提交
            // }
	    	if ($res['error_code'] == 'success') {
					$this->ajaxReturn(array('type'=>$type,'msg' => "创建机构成功！",'status'=> 1,'url' => 'http://b.cainiaobangbang.com/Info/Index/index'),'json');
				}else {
					$this->ajaxReturn(array('msg' => $res['error_description'],'status'=> 0),'json');
				}
    	}else{
            $area = smartAreas(array('code' => ""));//省列表
            $this->assign('area',$area);
            $trades = smartTrades();//行业
            $this->assign('trades',$trades);
            $company_type = Dicts(2);//公司性质
            $this->assign('company_type',$company_type);
    		$this->display('company-basicInfo');
    	}
    }


     /**
     * @desc 激活企业联系邮箱
     * @author zhuyi
     * @date 2016-09-02
     */
    public function Active_Com_Contarctmail()
    {
    	//redirect('/company/create', 1, '验证成功...');
        //手机跳转到H5
        if(is_mobile()){
           redirect('/m/notice/orgAuth.html');
        }
    	if(I('get.code') && I('get.time')){

    		$param['code'] = I('get.code');
    		$param['time'] = I('get.time');
    		if (empty($param['code']) || empty($param['time'])){
    			$this->error(U('index'));
    		}
    		$url = get_api_info('org','verify_contact_email'); //获取登录路由地址
			$res = request_api($url,$param,'post'); //请求
            //print_r($res);exit;
	    	if ($res['error_code'] == 'success') {
                    if(empty(session('user.access_token'))){
                        redirect('/hrLogin.html', 1, '验证成功,请重新登录...');
                    }else{
                        redirect('/company/create.html', 1, '验证成功...');
                    }
				}else {
                    redirect('/company/setMail.html', 1, '验证失败,请重新设置...');
					//$this->display("reVerify_contract");
			}
		}elseif(session('email')){
            $this->assign('tips','重新填写联系邮箱');
             $this->assign('url','/company/setMail.html');
             $this->assign('p_url','/company/resendEmail.html');
            $this->display("register-mail");
        }else{
            $this->error("出现错误");
        }
		  
    }

     /**
     * @desc 重新发送联系邮箱
     * @author zhuyi
     * @date 2016-09-02
     */
    public function Re_Auth_Contarct_Email(){

        $param['access_token'] = session('user.access_token');
        $param['email'] = I('post.email');
        if (empty($param['access_token'])||empty($param['email'])){
            $this->ajaxReturn(array('msg' => '参数错误','status'=> 0),'json');
        }
        $url = get_api_info('org','resend_contact_verify_email'); //获取登录路由地址
        $res = request_api($url,$param,'post'); //重新发送验证码
        if ($res['error_code'] != 'success'){
            $data['status'] = 0;
            $data['msg'] = $res['error_description'];
        }else{
            $data['info'] = $res;
            $data['status'] = 1;
            $data['msg'] = "联系邮箱重新发送发送成功";
        }
        $this->ajaxReturn($data,'json');
    }


     /**
     * @desc 重新填写联系邮箱
     * @author zhuyi
     * @date 2016-09-02
     */
    public function Re_Input_Contract_email(){

        $this->display("reVerify_contract");
    }

     /**
     * @desc 企业注册、创建成功
     * @author zhuyi
     * @date 2016-09-02
     */
    public function comRegSuccess(){
        
    	$this->display('comregSuccess');
    }

     /**
     * @desc 检查邮箱是否是企业邮箱
     * @author zhuyi
     * @date 2016-10-21
     */
    public function _check_org_email($token){

        $param['access_token'] = $token;
        $url = get_api_info('org','enterprise_email'); //获取登录路由地址
        $res = request_api($url,$param,'get'); //获取
        if(isset($res['error'])){
            return 0;
        }else{
            return $res;
        }
    }


    /**
    * @desc 消费简历查看联系方式
    * @param  ssid 快照ID
    * @author zhuyi
    * @date 2016-11-30
    */
    public function Confirm_See(){
        $data['access_token'] = cookie('cnbb_token');
        if( empty($data['access_token']) ){
            $this->ajaxReturn(array('msg' => '未登录','status'=> 0),'json');
        }
        $data['ssid'] = I("post.id");
        if( empty($data['ssid']) ){
            $this->ajaxReturn(array('msg' => '参数错误','status'=> 0),'json');
        }
        //查看简历联系方式
        $url = get_api_info('post','resume/buy');
        $res = request_api($url,$data,'post');  
        if( $res['error_code'] == "success" ){
            $this->ajaxReturn(array('msg' => 'success','status'=> 1),'json');
        }else{
            $this->ajaxReturn(array('msg' => $res['error_description'],'status'=> 0),'json');
        }

    }

}