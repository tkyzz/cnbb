<?php
namespace Home\Controller;
use Think\Controller;
class PostController extends Controller {

	public function __construct(){
		parent::__construct();
		$this->assign('navclass','post');
	}


	//岗位列表
	public function Post_List(){
		//手机跳转到H5
	    if(is_mobile()){
	       redirect('/m/postList.html');
	    }
		if (!empty(session("user.access_token"))){
			$param['access_token'] = session("user.access_token");
			$intention = getIntention(session('user.access_token'),1);
			if(!empty($intention['id'])){
				$is_yxcity = 1;
			}else{
				$is_yxcity = 0;
			}
			
			//$param['access_token'] = session('user.access_token');
		}
		$is_val = 0;
		$sec_isshow = 1;//搜索选项是否显示
		$param['size'] = C("PAGE_SIZE");//页大小
		if (!empty(I('get.page'))){//页码
			$param['page'] = I('get.page');
		}
		if (!empty(I('get.trade'))){//行业
			$is_val = 1;
			$param['org_trades'] = I('get.trade');
		}
		if (!empty(I('get.area'))){//城市
			$is_val = 1;
			$param['cities'] = I('get.area');
		}
		if (!empty(I('get.natures'))){//机构性质
			$is_val = 1;
			$param['org_natures'] = I('get.natures');
		}
		if (!empty(I('get.work_type'))){//工作类型
			$is_val = 1;
			$param['work_type'] = I('get.work_type');
		}
		if (!empty(I('get.work_day'))){//工作时长
			$is_val = 1;
			$param['work_duration'] = I('get.work_day')*30;
		}
		if (!empty(I('get.week_day'))){//每周工作天数
			$is_val = 1;
			$param['week_workdays'] = I('get.week_day');
		}
		if (!empty(I('get.degrees'))){//学历
			$is_val = 1;
			$param['degrees'] = I('get.degrees');
		}
		if (!empty(I('get.sort'))){//排序
			$param['sortby'] = I('get.sort');
			//距离最近
			if(I('get.sort') == 4){
				$param['client_ip'] = getClientIp();
			}
		}
		if (!empty(I('get.keyword'))){//关键字
			//搜索模式0公司1岗位
			$param['keyword_by'] = I('get.keyword_by');
			// if (!isset($param['keyword_by'])){
			// 	$param['keyword_by'] = I('get.keyword_by');
			// }
			$is_val = 1;
			if(I('get.ispage') <= 1){
				$key_arr = [
					'access_token' => session("user.access_token"),
					'src' => 1 ,
					'keyword' => I('get.keyword')
					];
				request_api(get_api_info('post',"search_keyword_count"),$key_arr,'get'); //提交统计关键词
			}
			$param['keyword'] = urlencode(I('get.keyword'));
		}
		if( $param['access_token'] ){
			if(I('get.sort') == -1){
				$sec_isshow = 0;
				unset($param['sortby']);
				$param['keyword_by'] = 99;//代表智能搜索
			}
		}else {
			if(I('get.sort') == -1){
				unset($param['sortby']);
			}
		}

		if(I('get.mode') == 'test'){
			print_r($param);
		}
		//print_r($param);
		
		$url = get_api_info('post',"search"); //获取登录路由地址
		$res = request_api($url,$param,'get'); //请求
		//var_dump($res);
		// $ip = get_client_ip();
		// if($ip != '183.195.157.158'){
		// 	$ids = array('987','772','95','96','93');
		// 	foreach($res['posts'] as $k=>$v){
		// 		if (in_array($v['id'],$ids)){
		// 			unset($res['posts'][$k]);
		// 		}
		// 	}	
		// }
		$page['total'] = $res['total'];
		$page['nowpage'] = $res['pages'];
		$page['size'] = $res['page_size'];
		$page['pages'] = ceil($res['total']/$res['page_size']);
		$org_natures = Dicts(2);//机构性质
		$work_type = Dicts(1);//工作类型
		$trades = smartTrades();
		$major_city = hotMainAreas(array('type'=>'major','t'=>2));//主要城市
        //print_r($trades);
        unset($trades['url']);
        $this->assign('sec_isshow',$sec_isshow);
        $this->assign('is_yxcity',$is_yxcity);
		$this->assign('city',$major_city);
		$this->assign('org_natures',$org_natures);
		$this->assign('work_type',$work_type);
		$this->assign('is_val',$is_val);
		$this->assign('trades',$trades);
		$this->assign('page',$page);//页面信息
		$this->assign('res',$res);
		$this->assign('nav','post');
		$this->display("postList");
	}

	//岗位列表AJAX
	public function Post_List_Ajax(){
		$is_val = 0;
		if (!empty(session("user.access_token"))){
			$param['access_token'] = session('user.access_token');
		}
		$param['size'] = C("PAGE_SIZE");//页大小
		if (!empty(I('get.page'))){//页码
			$param['page'] = I('get.page');
		}
		if (!empty(I('get.trade'))){//行业
			$is_val = 1;
			$param['org_trades'] = I('get.trade');
		}
		if (!empty(I('get.area'))){//城市
			$is_val = 1;
			$param['cities'] = I('get.area');
		}
		if (!empty(I('get.natures'))){//机构性质
			$is_val = 1;
			$param['org_natures'] = I('get.natures');
		}
		if (!empty(I('get.work_type'))){//工作类型
			$is_val = 1;
			$param['work_type'] = I('get.work_type');
		}
		if (!empty(I('get.work_day'))){//工作时长
			$is_val = 1;
			$param['work_duration'] = I('get.work_day')*30;
		}
		if (!empty(I('get.week_day'))){//每周工作天数
			$is_val = 1;
			$param['week_workdays'] = I('get.week_day');
		}
		if (!empty(I('get.degrees'))){//学历
			$is_val = 1;
			$param['degrees'] = I('get.degrees');
		}
		if (!empty(I('get.sort'))){//排序
			$param['sortby'] = I('get.sort');
			//距离最近
			if(I('get.sort') == 4){
				$param['client_ip'] = getClientIp();
			}
		}
		if (!empty(I('get.keyword'))){//关键字
			//搜索模式0公司1岗位
			$param['keyword_by'] = I('get.keyword_by');
			// if (!isset($param['keyword_by'])){
			// 	$param['keyword_by'] = I('get.keyword_by');
			// }
			$is_val = 1;
			if(I('get.ispage') <= 1){
				$key_arr = [
					'access_token' => session("user.access_token"),
					'src' => 1 ,
					'keyword' => I('get.keyword')
					];
				request_api(get_api_info('post',"search_keyword_count"),$key_arr,'get'); //提交统计关键词
			}
			$param['keyword'] = urlencode(I('get.keyword'));
		}
		if(I('get.sort') == -1 && $param['access_token']){
			unset($param['sortby']);
			$param['keyword_by'] = 99;//代表智能搜索
		}
		$url = get_api_info('post',"search"); //获取登录路由地址
		$res = request_api($url,$param,'get'); //请求
		//print_r($res);
		// if( $res['total'] <= 0 ){
		// 	$this->ajaxReturn(array('msg' => 'nojob','status'=> 0),'json');
		// }
		// $ip = getClientIp();
		// if($ip != '183.195.157.158'){
		// 	$ids = array('987','772','95','96','93');
		// 	foreach($res['posts'] as $k=>$v){
		// 		if (in_array($v['id'],$ids)){
		// 			//echo $v['id'];
		// 			unset($res['posts'][$k]);
		// 		}
		// 	}
		// }
		//print_r($res);
		$this->assign('res',$res);
		$html = $this->fetch("ajax_postList");
        $data['html'] = $html;
        $data['page'] = ceil($res['total']/10);
        $data['count'] = $res['total']?$res['total']:0;
        $data['is_val'] = $is_val;
        $data['param'] = $param;
		$data['msg'] = "success";
		$data['status'] =1;
		$this->ajaxReturn($data,'json');
	}

	//职位详情
	public function Post_Detail(){
		$id = I('get.id');
		//手机跳转到H5
        if(is_mobile()){
           redirect("/m/post/$id.html");
        }
		//邀请码
		$icode = I('get.icode');
		if(!empty($icode)){
			cookie('icode',$icode,1800);
		}
		//$device = I('get.t');
		if (!empty(session("user.access_token"))){
			$param['access_token'] = session('user.access_token');
		}
		if (empty(I('get.id'))){
			$this->error("页面找不到了");exit;
		}
		//var_dump(smartdictval(1));exit;
		$param['id'] = substr(base64_decode(I('get.id')),6);
		$url = get_api_info('post',$param['id']); //获取登录路由地址
		$res = request_api($url,$param,'get'); //获取详情
		//print_r($res);
		if(empty($res)){
			$this->error('页面找不到了','/index.html',2);
		}
		if(!empty($res['weal_tags'])){
			$res['fl_tags'] = explode('|',$res['weal_tags']);
		}
		// if(!empty($res['ssalary'])){
		// 	$res['esalary'] = 2000;
		// }
		$this->assign('res',$res);//职位详情
		//h5页面
		// if ($device == 'h5'){
		// 	$company_jobs = $this->_company_more_post(array('org_id'=>$res['org']['id'],'exclude_ids'=>$param['id']));
		// 	// $os = checkPhoneOs();
		// 	// if ($os == 'android'){
		// 	// 	$down_url = 'http://a.app.qq.com/o/simple.jsp?pkgname=com.finance.cainiaobangbang';
		// 	// }elseif ($os == 'ios'){
		// 	// 	$down_url = 'https://itunes.apple.com/us/app/cai-niao-bang-bang/id1002301865?mt=8';
		// 	// }
		// 	$this->assign('down_url','http://a.app.qq.com/o/simple.jsp?pkgname=com.finance.cainiaobangbang');//app下载链接
		// 	$this->assign('jobs',$company_jobs);//公司更多岗位
		// 	$this->display('postDetail-h5');
		// }else{
			if(!empty(session('user.access_token'))){
				//我的简历列表
				$url = get_api_info(1,'list/my'); //获取路由地址
				$myresume = request_api($url,array('access_token'=>session('user.access_token'),'need_deliver'=>'0'),'get'); //获取我的简历列表
				$this->assign('myresume',$myresume);//我的简历列表
			}

			$this->display('postDetails');
		//}
		
	}



	//公司详情BACKUP
	public function Company_Detail(){
		$param['access_token'] = session('user.access_token');
		$param['id'] = substr(base64_decode(I('get.id')),6);
		$url = get_api_info('org','get_byid'); //获取登录路由地址
		$res = request_api($url,$param,'get'); //得到更多岗位列表
		if(empty($res)){
			$this->error('页面找不到了','/index.html',2);
		}
		//print_r($res);
		$url = get_api_info('org','photo/sets'); //获取登录路由地址
		$org_photo = request_api($url,array('orgid'=> $res['id']),'get'); //获取公司图片集
		//print_r($org_photo);
		//获取图片
		$photo = array();
		foreach($org_photo as $k => $v){
			if ($org_photo[$k]['counts'] > 0){
				$url = get_api_info('org','photo/set/imgs'); //获取登录路由地址
				$photos = request_api($url,array('set_id'=> $v['id']),'get'); //获取公司图片集
				foreach($photos as $k => $v){
					$photo[] = $photos[$k]['img_url'];
				}
			}

		}
		$this->assign('com_photo',array_chunk($photo, 3));
		$this->assign('res',$res);//企业详情
		$this->display('companyProfile');                                                                                                                                                                                            
	}

	//公司详情
	public function Company(){
		//手机跳转到H5
	    if(is_mobile()){
	       redirect('/m/postList.html');
	    }
		if( session('user.access_token') )
		$param['access_token'] = session('user.access_token');
		$param['size'] = 5;
		if(!empty(I('get.id'))){
			$param['org_id'] = substr(base64_decode(I('get.id')),6);;
		}
		if(!empty(I('get.work_type'))){
			$param['work_type'] = I('get.work_type');
		}
		if(!empty(I('get.work_duration'))){
			$param['work_duration'] = I('get.work_duration');
		}
		if(!empty(I('get.week_day'))){
			$param['week_workdays'] = I('get.week_day');
		}
		$url = get_api_info('org','get_byid'); //获取登录路由地址
		$co_detail = request_api($url,array('id'=>$param['org_id']),'get'); //得到公司详情
		if(empty($co_detail)){
			$this->error('页面找不到了','/index.html',2);
		}

		$res = $this->_company_more_post($param);//print_r($co_detail);
		if(I('get.mode') == 'test'){
			print_r($res);
			echo '<br>';
			print_r($co_detail);
		}
		$this->assign('org_id',$param['org_id']);//机构ID
		$this->assign('res',$res);
		$this->assign('co_detail',$co_detail);//公司详情
		$this->display('company');
	}


	//投递成功
	public function Deliver_Success(){
		$param['access_token'] = session('user.access_token');
		if (empty($param['access_token'])){
			$this->error('请登录！',U('/index'));
		}
		if(!empty(I('get.id'))){
			$param['org_id'] = I('get.id');
		}
		$param['size'] = 5;//5个更多岗位
		$url = get_api_info('post',$param['org_id']); //获取登录路由地址
		$co_detail = request_api($url,$param,'get'); //得到公司详情
		$trade_id = $co_detail['org']['trade_id'];
		$co_post = $this->_company_more_post($param);//此公司更多岗位
		$url = get_api_info("post","search"); //获取登录路由地址
		$simjob = request_api($url,array("size" => 3,"org_trades"=>$trade_id),'get'); //获取相似职位
		//$this->assign('co_detail',$co_detail);//公司详情
		$this->assign('co_post',$co_post);//公司更多岗位
		$this->assign('simjob',$simjob);//相似职位
		$this->display('submitResume');
	}

	/**
	* @desc 获取公司更多岗位
	* @author zhuyi
	* @date 2016-12-23
	*/
	public function _company_more_post($param){
		if(empty($param)){
			return false;
		}
		$url = get_api_info('post','search'); //获取登录路由地址
		$data = request_api($url,$param,'get'); //得到更多岗位列表
		if(empty($data)){
			return false;
		}
		return $data;
	}



	/**
	* @desc 获取相似职位
	* @author zhuyi
	* @date 2016-10-08
	*/
	public function Sim_Job(){
		//$param['access_token'] = session('user.access_token');
		$param['trade_id'] = I('post.trade_id');
		$param['exclude_ids'] = I('post.exclude_id');
		$param['size'] = 8;
	    if (empty($param['trade_id'])||empty($param['exclude_ids'])){
	        $this->ajaxReturn(array('msg' => '参数错误','status'=> 0),'json');
	    }
		$url = get_api_info("post","search"); //获取登录路由地址
		$simjob = request_api($url,$param,'get'); //获取相似职位
		ob_start();
		$this->assign('simjob',$simjob);//相似职位
		$this->display("/post/ajax_simjob");
	    $html = ob_get_contents();
	    ob_clean();
		if (empty($simjob)){
			$data['status'] = 0;
			$data['msg'] = '失败';
		}else{
			$data['html'] = $html;
			$data['status'] = 1;
			$data['msg'] = "成功";
		}
		$this->ajaxReturn($data,'json');
	}












}