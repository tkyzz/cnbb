<?php
//author zhuyi
namespace Home\Controller;
use Think\Controller;
class StudentController extends \Components\BaseController {

 /**
 * @desc 构造
 * @author zhuyi
 * @date 2016-07-02
 */
public function __construct(){
    parent::__construct();
	//手机跳转到H5
    if(is_mobile()){
       redirect('/m/postList.html');
    }
    $this->assign('navclass','student');
   	if(!check_login()){
       $this->error('请登录','/logout.html',2);
    }
    //print_r(session('member'));
    // if(cookie('cnbb_token')){
    // 	$this->error('企业账号无法操作','/index.html',2);
    // }
}

 /**
 * @desc 账号设置
 * @author zhuyi
 * @date 2016-07-02
 */
public function Account_Setting(){
	$param['access_token'] = session("user.access_token"); //access_token
	$param['uid'] = session("user.uid"); //用户ID
	$url = get_api_info('passport',$param['uid']); //获取改密码路由地址
	$res = request_api($url,$param,'get'); //更改密码
    if (isset($res['error_code']) && $res['error_code']=='unauthorized'){
    	$this->error('您已在其他地方登录，请重新登录','/logout.html',2);
        //redirect(U('/logout'), 1, '您已在其他地方登录，请重新登录');
    }
	//print_r($res);
	$this->assign('data',$res);
	$this->assign('nav',"favorite");
	$this->display('settings');
}

 /**
 * @desc 修改个人信息
 * @author zhuyi
 * @date 2016-07-02
 */
public function Update_Info(){

	$param['nick_name'] = I('post.nickname'); //昵称
    $param['avatar_id'] = I('post.avatar_id'); //头像id
    $param['gender'] = I('post.gender');//性别
	$param['access_token'] = session("user.access_token"); //access_token
    foreach($param as $k=>$v){
        if(empty($v)){
            unset($param[$k]);//清空空数据
        }
    }
    //var_dump($param);
	$url = get_api_info('passport','info/nick_name'); //获取改密码路由地址
	$res = request_api($url,array('access_token'=>$param['access_token'],'nick_name'=>$param['nick_name']),'put'); //更改密码
    $url = get_api_info('passport','info'); //获取改密码路由地址
    $res = request_api($url,$param,'put'); //修改个人信息
    if (isset($res['error_code']) && $res['error_code']=='unauthorized'){
       $this->error('您已在其他地方登录，请重新登录','/logout.html',2);
    }
	if ($res['error_code'] != 'success'){
			$this->error($res['error_description ']);exit;
	}else{
			session('member.nick_name',$param['nick_name']);//将昵称加入session.member
			$this->success("修改成功");exit;
	}

}

 /**
 * @desc 账号设置、修改密码
 * @author zhuyi
 * @date 2016-07-02
 */
public function Change_Pwd(){
	if (IS_POST){

		$param['password'] = I('post.oldpassword'); //旧密码
    	$param['device'] = 1; //设备标识
    	$param['account_name'] = session("user.account_name"); //用户名
    	$uid = I("session.user")['uid'];//用户ID
    	if (empty($param['password']) && empty($param['account_name'])){
    		$this->error("参数错误");exit;
    	}
    	$url = get_api_info(0,'login'); //获取登录路由地址
		$res = request_api($url,$param,'post'); //请求
		if (empty($res['access_token'])){
			$this->error("密码错误");exit;
		}
		$param['password'] = I('post.newpassword');
		$param['access_token'] = $res['access_token'];
		unset($param['device'],$param['account_name']);
		$url = get_api_info(4,'password'); //获取改密码路由地址
		$res = request_api($url,$param,'put'); //更改密码
		if (isset($res['error_description '])){
			$this->error($res['error_description ']);exit;
		}else{
			$this->ajaxReturn(array('msg' => '修改成功','status'=> 1,'url'=>'/logout.html'),'json');
		}
	}else{
    	$this->assign('nav',"favorite");
    	$this->display('changePassword');
	}
	


}

 /**
 * @desc 我的简历列表
 * @author zhuyi
 * @date 2016-07-02
 */
public function Resume_List(){
	//手机自动跳转到H5
    if(is_mobile()){
       redirect('/mmyResume.html');
    }
	$param['access_token'] = session('user.access_token');
	//echo $param['access_token'];
	if (empty($param['access_token'])) {
		$this->error("请登录！");exit;
	}
	$url = get_api_info(1,'list/my'); //获取路由地址
	$res = request_api($url,$param,'get'); //请求
	//print_r($res);
    //$res = json_decode()
	if (isset($res['error_code'])){
		if($res['error_code']=='unauthorized'){
			$this->error('您已在其他地方登录，请重新登录','/logout.html',2);
		}
		$this->error("未知错误");exit;
	}	
	//echo $res[0]['id'];
	$intention = getIntention($param['access_token'],$res[0]['id']);
	//print_r($intention);
	if($intention['id']){
			if(count($intention['trades'])){
				$intention['tradeid'] = implode('/',array_keys($intention['trades']));
				$intention['tradestr'] = implode('/',$intention['trades']);
			}
			if(count($intention['work_cities'])){
				$intention['work_citiesid'] = implode('/',array_keys($intention['work_cities']));
				$intention['work_citiesstr'] = implode('/',$intention['work_cities']);
			}

	}
	//print_r($intention);
	if(I('get.mode') == 'test'){
		print_r($res);
	}
	$area = smartAreas(array('code' => ""));//省列表
	$this->assign('area',$area);
	$trades = smartTrades();//行业
	$this->assign('intention',$intention);//求职意向
	//print_r($intention);
	$this->assign('trades',$trades);
	if(I('get.show') == 1){
		$is_show = 2;
	}else{
		$is_show = $this->_is_intention_show();
	}
	$this->assign('is_show',$is_show);
	$this->assign('res',$res);
	// print_r($param);
 //    print_r($res);
	$this->assign('nav',"resume");
	$this->display('myProfile');

}


 /**
 * @desc 我的收藏
 * @author zhuyi
 * @date 2016-07-02
 */
public function My_Favorite(){
	$param['access_token'] = I("session.user")['access_token'];
	$param['page'] = 1;
	$param['size'] = 10;
	//我的简历列表
	$url = get_api_info(1,'list/my'); //获取路由地址
	$myresume = request_api($url,$param,'get'); //获取我的简历列表
	// foreach($myresume as $v){
	// 	if ($v['is_default'] == 1){
	// 		$is_default = $v['id'];
	// 	}
	// }

	$url = get_api_info(6,'user/favs'); //获取路由地址
	$res = request_api($url,$param,'get'); //获取收藏列表
    // print_r(session('user'));
    // print_r($res);exit;
    if (isset($res['error_code']) && $res['error_code']=='unauthorized'){
        redirect(U('/logout'), 1, '您已在其他地方登录，请重新登录');
    }
	$this->assign('res',$res);
	$this->assign('myresume',$myresume);//我的默认简历
	$this->assign('posts',$res['posts']);//print_r($res);
	$this->assign('nav',"favorite");
	$this->display('myFavorite');
}


 /**
 * @desc 简历详情
 * @author zhuyi
 * @date 2016-07-02
 */
public function Resume_Detail(){

	$param['access_token'] = session("user.access_token");
	$url_id = substr(base64_decode(I('get.id')),6);
	if (empty($param['access_token'])){
		$this->error("非法操作",U('user/login'));exit;
	}
	$param['id'] = $url_id;
	$param['resume_id'] = $url_id;
	$url = get_api_info(1,'detail/'.$param['id']); //获取路由地址
	$res = request_api($url,$param,'get'); //获取简历详情
	if(empty($res)){
		$this->error('404 页面找不到了。。。。');
	}
	if (isset($res['error_code']) && $res['error_code']=='unauthorized'){
		redirect(U('/logout'), 1, '登录出现异常,请重新登录...');
	}
	foreach($res['intention']['work_cities'] as $k=>$v)
	{
		$id[] = $k;
		$name[] = $v;
	}
	$res['intention']['work_cities']['id'] = implode('/',$id);
	$res['intention']['work_cities']['name'] = implode('/',$name);
	unset($id,$name);
	foreach($res['intention']['trades'] as $k => $v)
	{
		$id[] = $k;
		$name[] = $v;
	}
	$res['intention']['trades']['id'] = implode('/',$id);
	$res['intention']['trades']['name'] = implode('/',$name);
     //    <foreach name="v.pass_courses" item="vo" key="k">
     //    <if condition="$vo elt 39">
     //       <span>{$v['coursenames'][$k]}</span>
     //    </if>
     // </foreach>
     // 连接生成财金证书的ACCA的项目
     foreach($res['certificates'] as $k => $v){
     	$farr = array();
     	$parr = array();
     	foreach ($v['pass_courses'] as $key => $value) {
     		//F阶段
     		if($value <= 39){
     			$farr[] =  $v['coursenames'][$key];
     		}
     		//P阶段
     		if($value >= 40){
     			$parr[] =  $v['coursenames'][$key];
     		}
     	}
     	$res['certificates'][$k]['fcourse'] = implode('；',$farr);
     	$res['certificates'][$k]['pcourse'] = implode('；',$parr);
     }
     //print_r($res['certificates']);
    $mytags = implode('|',$res['info']['tags']);//我的标签转成字符串
	//print_r($intention);
	$area = smartAreas(array('code' => "",'nohw'=>'true'));//省列表
	$eduarea =  smartAreas(array('code' => ""));//教育经历省列表
	$this->assign('area',$area);
	$this->assign('eduarea',$eduarea);
	$politics = ResumeDict('politics');//政治面貌
	$hktype = ResumeDict('hktype');//户口类型
	//print_r($hktype);
	$tags = ResumeDict('self_tag');//个人标签
	$trades = smartTrades();//行业
	$work_type = Dicts(1);//工作类型
    $company_type = Dicts(2);//公司性质
    $wfs = smartWfs();//职能
    $cert_type = getCertificateTypes();
    $major_list = getMajorCategories(array('access_token' => $param['access_token']));
    $countries = getCountry();//国家列表
    $this->assign('mytags',$mytags);//我的标签
    $this->assign('wfs',$wfs);//职能列表
    $this->assign('company_type',$company_type);//公司性质
    $this->assign('countries',$countries);//国家列表
    $this->assign('major_list',$major_list);//专业列表
	$this->assign('politics',$politics);
	$this->assign('hktype',$hktype);
	$this->assign('tags',$tags);//print_r($res['certificates']);
	$this->assign('certificates',$res['certificates']);//证书
   // print_r($res['certificates']);
	$this->assign('intention',$res['intention']);//求职意向
	$this->assign('trades',$trades);//print_r($trades);
	$this->assign('work_type',$work_type);//print_r($res['edus']);
	$this->assign('edus',$res['edus']);//教育经历
	$this->assign('info',$res['info']);//个人信息
    //print_r($res['skill']);
	$this->assign('internships',$res['internships']);//实习经历
	$this->assign('rjp',$res['rjp']);//校内经历
    $this->assign('cert_type',$cert_type);//证书类型
    //echo smartEnLang($res['skill']['en_level']);
    if(!empty($res['skill']['id'])){
    	$res['skill']['enskill'] = ' ';
    	if($res['skill']['en_level'] >= -1){
    		$res['skill']['enskill'] .= smartEnLang($res['skill']['en_level']);
    		if($res['skill']['english_score'] > 0 && $res['skill']['en_level'] >= 0){
    			$res['skill']['enskill'] .= "（{$res['skill']['english_score']}）";
    		}
    		
    	}
    	if(!empty($res['skill']['ielts'])){
    		//cho $res['skill']['enskill'];
    		$res['skill']['enskill'] .= '；';
			$res['skill']['enskill'] .= '雅思';
			if($res['skill']['ielts'] != -1){
    			$res['skill']['enskill'] .="（{$res['skill']['ielts']}）";
    		}
    		
    	}
    	if(!empty($res['skill']['toefl'])){
    		$res['skill']['enskill'] .= '；';
    		$res['skill']['enskill'] .= '托福';
    		if($res['skill']['toefl'] != -1){
    			$res['skill']['enskill'] .="（{$res['skill']['toefl']}）";
    		}
    		//$res['skill']['enskill'] .= ';';
    	}
    }
    //print_r($res['skill']);
	$this->assign('skill',$res['skill']);//技能
	$this->assign('res',$res);
	if(I('get.mode') == 'test'){
		print_r($res);
	}
	$this->assign('nav',"resume");
	$this->assign('js',"new");
	//print_r($res);
    if (I("get.type") == 'view'){
        $this->display('profilePreview');
        //$this->display('index/profilePreview');
    }elseif (I("get.type") == 'detail'){
        //print_r($res['certificates']);
        $this->display('profileEdit');

    }
	

}

 /**
 * @desc 投递反馈
 * @author zhuyi
 * @date 2016-07-02
 */
public function My_Feedback(){
    $param['access_token'] = session("user.access_token");
    if (empty($param['access_token'])){
        $this->error("非法操作",U('user/login'));exit;
    }
    $param['status'] = I("get.st",100);
    // if($param['status']!=100){
    //     $param['status'] -=1;//由于页面0不好判断，故+1
    // } 
    ///print_r($param);
    $url = get_api_info('post','user/delivereds'); //获取路由地址
    $res = request_api($url,$param,'get'); //请求
    //print_r($res);
    if(I('get.mode') == 'test'){
    	print_r($res);
    }
    if (isset($res['error_code']) && $res['error_code']=='unauthorized'){
        redirect(U('/logout'), 1, '登录出现异常,请重新登录...');
    }
    $this->assign('nav','feed');
    $this->assign('res',$res);
    $this->display('myFeedback');
}


 /**
 * @desc 我的面试通知
 * @author zhuyi
 * @date 2016-07-02
 */
public function My_Notice(){
    $param['access_token'] = session("user.access_token");
    //$param['session_id'] = I('get.session_id','57c280fa72fedf1bcc7bbc02');

    if (empty($param['access_token'])){
        $this->error("非法操作",U('user/login'));exit;
    }
    //$param['status'] = I("get.st",100);
    $url = get_api_info('post','notice/messages/my'); //获取路由地址
    $res = request_api($url,$param,'get'); //请求
    if (isset($res['error_code']) && $res['error_code']=='unauthorized'){
        redirect(U('/logout'), 1, '登录出现异常,请重新登录...');
    }
    foreach($res['sessions'] as $k => &$v){
        $v['msg_count'] = count($v['messages']);
    }
    if(I('get.mode') == 'test'){
    	print_r($res);
    }
    //print_r($res);
    $this->assign('res',$res['sessions']);
    $this->assign('nav','notice');
    $this->display('myNotice');
}


 /**
 * @desc 专属推荐
 * @author zhuyi
 * @date 2016-11-08
 */
public function Message_Center(){
	//print_r(session('user'));
    $param['access_token'] = session("user.access_token");
    $param['page'] = I('get.p',1);
    $param['size'] = C("PAGE_SIZE");
    if (empty($param['access_token'])){
        $this->error("非法操作",U('user/login'));exit;
    }
    $url = get_api_info('post','user/recommends'); //获取路由地址
    $res = request_api($url,$param,'get'); //请求
    $res['pageCount'] = ceil($res['total']/C("PAGE_SIZE"));//总页码
    //print_r($res);
    if (isset($res['error_code']) && $res['error_code']=='unauthorized'){
        redirect(U('/logout'), 1, '登录出现异常,请重新登录...');
    }
	//我的简历列表
	$url = get_api_info(1,'list/my'); //获取路由地址
	$myresume = request_api($url,array('access_token'=>session('user.access_token')),'get');
	//print_r($myresume);
	//重置消息通知计数
    $url = get_api_info('post','user/readrecommend');
    request_api($url,array('access_token'=>$param['access_token']),'post');
	//获取通知数量
	session('message_num',_get_notice());
	//print_r(getUserBrowser());
	//默认简历ID
	$this->assign('browser',getUserBrowser()[0]);
	$this->assign('is_show',$this->_is_intention_show());
	$this->assign('resume_default_id',$myresume[0]['id']);
    $this->assign('res',$res);
    $this->assign('nav','message');
    $this->display('msgCenter');
}

 /**
 * @desc 是否求职意向弹窗
 * @author zhuyi
 * @date 2016-11-09
 */
public function _is_intention_show(){
    $param['access_token'] = session("user.access_token");
    if (empty($param['access_token'])){
       return false;
    }
    if(cookie('intention_tip') == 1){
    	return 0;
    }
	$intention = getIntention($param['access_token']);
	//print_r($intention);
	//是否弹框
	$is_show = 0;
	//var_dump(cookie('intention_tip'));
	//当第一次关闭首页求职意向一律不弹出
	if(session('member.is_intention_show') == 1){
		$is_show = 0;
	}else{
		if($intention['id']){
			if(count($intention['trades'])==0 && count($intention['work_cities'])==0){
				$is_show = 1;
			}
		}else{
			$is_show = 1;
		}	
	}
	//var_dump($intention['trades'][0]==0);
	//$is_show;
	return $is_show;

}


 /**
 * @desc 系统通知
 * @author zhuyi
 * @date 2016-07-02
 */
public function System_Notice(){
    $this->display('systemNotice');
}

 /**
 * @desc 邀请码
 * @author zhuyi
 * @date 2016-09-12
 */
public function Invitation(){

	$param['access_token'] = session("user.access_token");
	if (IS_POST){
		$param['code'] = I('post.code');
		if (empty($param['access_token']) || empty($param['code'])){
			$this->ajaxReturn(array('msg' => '参数错误','status'=> 0),'json');
		}
	    $url = get_api_info('passport','set_icode'); //获取路由地址
	    $res = request_api($url,$param,'post'); //请求
	    //print_r($res);
		if ($res['error_code']!='success'){
			$this->ajaxReturn(array('msg' => $res['error_description '],'status'=> 0),'json');
		}else{
				$data['msg'] = "操作成功！";
				$data['status'] =1;
				$this->ajaxReturn($data,'json');
		}
	}else{
		$url = get_api_info('passport','icode_state'); //获取路由地址
	    $res = request_api($url,$param,'get'); //请求
	   // print_r($res);
	    $this->assign('code',$res['code']);//邀请码
		$this->display('invitation');
	}
    
}









}