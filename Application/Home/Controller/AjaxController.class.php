<?php
//author zhuyi
namespace Home\Controller;
use Think\Controller;
class AjaxController extends \Components\BaseController {
	public function _construct(){
		//$this->$token = 
	}

	//根据省id获取市
	public function Get_City(){
		$param['code'] = I('get.code');
		$data['msg'] = smartAreas($param);
		$data['status'] =1;
		$data['info'] = "获取成功";
		//print_r($data);
		$this->ajaxReturn($data,'json');
	}

	//取消/收藏简历
	public function User_Fav(){
		$param['access_token'] = session('user.access_token');
		if (empty($param['access_token'])){
			$this->ajaxReturn(array('msg' => '请登录！','status'=> 0),'json');
		}
		$type = I('post.type');
		if (!($type == 'post'||$type == 'delete')){
			$this->ajaxReturn(array('msg' => '参数错误','status'=> 0),'json');
		}
		$param['post_id'] = I('post.post_id');
		$url = get_api_info(6,'user/fav'); //获取登录路由地址
		$res = request_api($url,$param,$type); //取消、收藏简历
		//print_r($res);
		if ($res['error_code']!='success'){
			$this->ajaxReturn(array('msg' => $res['error_description'],'status'=> 0),'json');
		}else{
			if ($type == 'post'){
				$data['msg'] = "收藏成功";
				$data['status'] =1;
				$data['info'] = $res;
				$this->ajaxReturn($data,'json');
			}elseif($type =='delete'){
				$data['msg'] = "取消收藏成功";
				$data['status'] =1;
				$data['info'] = $res;
				$this->ajaxReturn($data,'json');
			}
		}

	}

	//投递简历
	public function Post_Resume(){
		$param['access_token'] = session('user.access_token');
		if (empty($param['access_token'])){
			$this->ajaxReturn(array('msg' => '未许可的操作','status'=> 0),'json');
		}
		$param['post_id'] = I('post.post_id');//岗位ID
		$param['resume_id'] = I('post.resume_id');//简历ID
		$param['device'] = I('post.device',1);//设备web
		$url = get_api_info('post','deliver'); //获取登录路由地址
		$res = request_api($url,$param,'post'); //取消、收藏简历
		//print_r($res);
		if ($res['error_code']!='success'){
			$this->ajaxReturn(array('msg' => $res['error_description'],'status'=> 0),'json');
		}else{
				$data['msg'] = "投递成功,请静候佳音！";
				$data['status'] =1;
				$this->ajaxReturn($data,'json');
		}


	}


	//获取求职意向/匹配职位
	public function Get_Intention(){

		$param['access_token'] = session('user.access_token');
		if (empty($param['access_token'])){
			$this->ajaxReturn(array('info' => '您还未登录！','status'=> 0),'json');
		}
		$param['resume_id'] = I("post.resume_id");
		$url = get_api_info(1,'intention/get');
		$intention = request_api($url,$param,'get'); //获取求职意向
		$intention['work_duration'] /= 30; 
		if(reset($intention['trades'])){
			$intention['trade'] = implode('/',$intention['trades']);//行业转字符串
			$intention['trade_id'] = array_keys($intention['trades']);
		}else{
			$intention['trade'] = '不限';//行业转字符串
			$intention['trade_id'] = 0;
		}
		if(reset($intention['work_cities'])){
			$intention['city'] = implode('/',$intention['work_cities']);//城市转字符串
			$intention['city_id'] = array_keys($intention['work_cities']);
		}else{
			$intention['city'] = '不限';
			$intention['city_id'] = 0;
		}

		$intention['work_type_name'] = smartWorkType($intention['work_type']); 
		$param['trade'] = I("post.trade");//当前职位行业
		$param['city'] = I("post.city");//当前职位城市
		$param['work_type'] = I("post.work_type");//当前职位工作类型
		$param['work_duration'] = I("post.work_duration");//当前职位连续工作天数
		$param['week_workdays'] = I("post.week_workdays");//当前周工作天数
		$intention['result']['trade'] = 0;
		$intention['result']['city'] = 0;
		$intention['result']['work_type'] = 0;
		$intention['result']['work_duration'] = 0;
		$intention['result']['week_workdays'] = 0;
		$intention['result']['work_days'] = 0;
		if (in_array($param['trade'],$intention['trade_id']) || !reset($intention['trades'])){
			$intention['result']['trade'] = 1;
		}
		if (in_array($param['city'],$intention['city_id']) || !reset($intention['work_cities'])){
			$intention['result']['city'] = 1;
		}
		if ($param['work_type'] == $intention['work_type']){
			$intention['result']['work_type'] = 1;
			if($param['work_duration'] == $intention['work_duration']){
				$intention['result']['work_duration'] = 1;
			}
			if($param['week_workdays'] == $intention['week_workdays']){
				$intention['result']['week_workdays'] = 1;
			}
		}
		if ($intention['result']['work_duration'] && $intention['result']['week_workdays']){
			$intention['result']['work_days'] = 1;
		}
		unset($intention['result']['work_duration'],$intention['result']['week_workdays']);
		$intention['city_id'] = implode("/",$intention['city_id']);
		$intention['trade_id'] = implode("/",$intention['trade_id']);
		//print_r($intention);
		if (isset($intention)){
			$this->ajaxReturn(array('info'=>$intention,'msg' =>'获取成功' ,'status'=> 1),'json');
		}else{
				$data['msg'] = "获取失败！";
				$data['status'] =0;
				$this->ajaxReturn($data,'json');
		}



	}


	//创建、更新和删除简历(简历名称)
	public function Cre_Up_Resume(){

		$param['access_token'] = session('user.access_token');
		if (empty($param['access_token'])){
			$this->ajaxReturn(array('msg' => '您还未登录！','status'=> 0),'json');
		}
		$param['name'] = I("post.name");
		$param['open_level'] = I("post.open_level");
		$type = I("post.type");
		if ($type == 'create'){
			$url = get_api_info(1,'create'); //获取路由地址
			$res = request_api($url,$param,'post'); //创建简历
		}elseif ($type == 'update'){
			$param['id'] = I('post.id');
			if (empty($param['id'])){
				$this->ajaxReturn(array('msg' => '参数错误','status'=> 0),'json');
			}
			$url = get_api_info(1,'update'); //获取路由地址
			$res = request_api($url,$param,'put'); //创建简历
		}elseif ($type == 'del'){
			$param['id'] = I('post.id');
			if (empty($param['id'])){
				$this->ajaxReturn(array('msg' => '参数错误','status'=> 0),'json');
			}
			$url = get_api_info(1,'del'); //获取路由地址
			$res = request_api($url,$param,'delete'); //删除简历
		}else{
			$data['msg'] = "参数错误";
			$data['status'] =0;
			$this->ajaxReturn($data,'json');
		}
		if ($res['error_code']!='success'){
			$this->ajaxReturn(array('msg' => $res['error_description '],'status'=> 0),'json');
		}else{
				$res['result'] = smartBase64($res['result']);
				$data['msg'] = "操作成功！";
				$data['status'] =1;
				$data['info'] = $res;
				$this->ajaxReturn($data,'json');
		}
	}

/**
 * @desc 设置默认简历
 * @author zhuyi
 * @date 2016-07-02
 */
public function Set_Default(){
	$param['access_token'] = session('user.access_token');
	if (empty($param['access_token'])){
		$this->ajaxReturn(array('msg' => '您还未登录！','status'=> 0),'json');
	}
	$param['resume_id'] = I('post.id');
	if (empty($param['resume_id'])){
		$this->ajaxReturn(array('msg' => '参数错误！','status'=> 0),'json');
	}
	$url = get_api_info(1,'set_default'); //获取路由地址
	$res = request_api($url,$param,'post'); //设置默认简历
	if ($res['error_code']!='success'){
		$this->ajaxReturn(array('msg' => $res['error_description '],'status'=> 0),'json');
	}else{
			$data['msg'] = "操作成功！";
			$data['status'] =1;
			$data['info'] = $res;
			$this->ajaxReturn($data,'json');
	}
}


 /**
 * @desc 根据省获取学校列表
 * @author zhuyi
 * @date 2016-07-02
 */
public function Province_Get_School(){
	$param['province_id'] = I("get.code");
	$url = get_api_info(1,'school/list_by_province'); //获取路由地址
	$res = request_api($url,$param,'get'); //设置默认简历
	//print_r($res);
	$data['msg'] =  "获取成功";
	$data['status'] =1;
	$data['info'] =	$res;
	$this->ajaxReturn($data,'json');
}

 /**
 * @desc 获取教育经历专业
 * @author zhuyi
 * @date 2016-07-02
 */
public function Get_Major_Categories(){
	$param['access_token'] = session('user.access_token');
    if (empty($param['access_token'])){
        $this->ajaxReturn(array('msg' => '参数错误','status'=> 0),'json');
    }
    $url = get_api_info(1,"edu/major_categories"); //获取路由地址
    $res = request_api($url,$param,"get"); //请求
    if(empty($res)){
       $this->ajaxReturn(array('msg' => '内容为空','status'=> 0),'json');
    }
    	$data['msg'] =  "获取成功";
		$data['status'] =1;
		$data['info'] =	$res;
		$this->ajaxReturn($data,'json');
}

 /**
 * @desc 获取教育经历（单个）
 * @author zhuyi
 * @date 2016-07-02
 */
public function Get_Edu_Detail(){

	$param['access_token'] = session('user.access_token');
    if (empty($param['access_token'])){
        $this->ajaxReturn(array('msg' => '参数错误','status'=> 0),'json');
    }	
    $type = I('get.type');
    $param['id'] = I('get.id');
    if (empty($param['id'])){
    	$this->ajaxReturn(array('msg' => '参数错误','status'=> 0),'json');
    }
    $url = get_api_info(1,"edu/".$param['id']); //获取路由地址
    $res = request_api($url,$param,"get"); //请求
    $res['syear'] = (int)substr($res['sdate'],0,4);
    $res['smonth'] = (int)substr($res['sdate'],4,2);
    $res['eyear'] = (int)substr($res['edate'],0,4);
    $res['emonth'] = (int)substr($res['edate'],4,2);
    switch ( $type ) {
    	case 'exchange':
	    	$id = I('get.exchange_id');
	    	foreach($res['exchanges'] as $k => $v){
		    		if ($id == $v['id']){
		    			$res = $res['exchanges'][$k];
		    		}
	    		}
		    $res['edu_id'] = $param['id'];//教育经历ID
		    $res['syear'] = (int)substr($res['sdate'],0,4);
		    $res['smonth'] = (int)substr($res['sdate'],4,2);
		    $res['eyear'] = (int)substr($res['edate'],0,4);
		    $res['emonth'] = (int)substr($res['edate'],4,2);
    		break;
    	case 'other':
    		$id = I('get.other_id');
	    	foreach($res['others'] as $k => $v){
		    		if ($id == $v['id']){
		    			$res = $res['others'][$k];
		    		}
	    	}
	    	$res['edu_id'] = $param['id'];//教育经历ID
	    	$res['syear'] = (int)substr($res['sdate'],0,4);
		    $res['smonth'] = (int)substr($res['sdate'],4,2);
		    $res['eyear'] = (int)substr($res['edate'],0,4);
		    $res['emonth'] = (int)substr($res['edate'],4,2);
    		break;
    	default:
    		# code...
    		break;
    }
    if(empty($res)){
       $this->ajaxReturn(array('msg' => '内容为空','status'=> 0),'json');
    }
    	$data['msg'] =  "获取成功";
		$data['status'] =1;
		$data['info'] =	$res;
		$this->ajaxReturn($data,'json');

}

 /**
 * @desc 根据证书类别获取证书科目
 * @author zhuyi
 * @date 2016-07-02
 */
public function Get_Cert_Courses(){
	$param['cid'] = I('get.cid');
	if (empty($param['cid'])){
        $this->ajaxReturn(array('msg' => '参数错误','status'=> 0),'json');
    }
    $url = get_api_info(1,"certificate/courses"); //获取路由地址
    $res = request_api($url,$param,"get"); //请求
    if(empty($res)){
       $this->ajaxReturn(array('msg' => '内容为空','status'=> 0),'json');
    }
    	$data['msg'] =  "获取成功";
		$data['status'] =1;
		$data['info'] =	$res;
		$this->ajaxReturn($data,'json');

}

 /**
 * @desc 获取实习经验（单个）
 * @author zhuyi
 * @date 2016-07-02
 */
public function Get_Internship(){
	$param['access_token'] = session('user.access_token');
    if (empty($param['access_token'])){
        $this->ajaxReturn(array('msg' => '参数错误','status'=> 0),'json');
    }
	$param['id'] = I('get.id');
    $url = get_api_info(1,"internship/get"); //获取路由地址
    $res = request_api($url,$param,"get"); //请求
    if(empty($res)){
       $this->ajaxReturn(array('msg' => '内容为空','status'=> 0),'json');
    }
    	$res['syear'] = (int)substr($res['sdate'],0,4);
	    $res['smonth'] = (int)substr($res['sdate'],4,2);
	    $res['eyear'] = (int)substr($res['edate'],0,4);
	    $res['emonth'] = (int)substr($res['edate'],4,2);
	    $res['func'] = $res['function']; 
    	$data['msg'] =  "获取成功";
		$data['status'] =1;
		$data['info'] =	$res;
		$this->ajaxReturn($data,'json');
}


 /**
 * @desc 获取技能
 * @author zhuyi
 * @date 2016-07-02
 */
public function Get_Skill(){
	$param['access_token'] = session('user.access_token');
    if (empty($param['access_token'])){
        $this->ajaxReturn(array('msg' => '参数错误','status'=> 0),'json');
    }
    $param['resume_id'] = I('get.resume_id');
    if (empty($param['resume_id'])){
    	 $this->ajaxReturn(array('msg' => '参数错误','status'=> 0),'json');
    }
    $url = get_api_info(1,"skill/get"); //获取路由地址
    $res = request_api($url,$param,"get"); //请求
    if(empty($res)){
       $this->ajaxReturn(array('msg' => '内容为空','status'=> 0),'json');
    }
    	$data['msg'] =  "获取成功";
		$data['status'] =1;
		$data['info'] =	$res;
		$this->ajaxReturn($data,'json');
}

 /**
 * @desc 获取证书（单个）
 * @author zhuyi
 * @date 2016-07-02
 */
public function Get_cert(){
	$param['access_token'] = session('user.access_token');
    if (empty($param['access_token'])){
        $this->ajaxReturn(array('msg' => '参数错误','status'=> 0),'json');
    }
    $param['resume_id'] = I('get.resume_id');
    $id = I('get.id');
    if (empty($param['resume_id'])||empty($id)){
    	 $this->ajaxReturn(array('msg' => '参数错误','status'=> 0),'json');
    }
    $url = get_api_info("resume","certificate/list"); //获取路由地址
    $res = request_api($url,$param,"get"); //请求
    if(empty($res)){
       $this->ajaxReturn(array('msg' => '内容为空','status'=> 0),'json');
    }
    foreach($res as $k => $v){
    	if ($v['id'] == $id){
    		$res = $res[$k];
    	}
    }
    	$data['msg'] =  "获取成功";
		$data['status'] =1;
		$data['info'] =	$res;
		$this->ajaxReturn($data,'json');
		
}

 /**
 * @desc 获取校内荣誉
 * @author zhuyi
 * @date 2016-07-02
 */
public function Get_Reward(){
	$param['access_token'] = session('user.access_token');
    if (empty($param['access_token'])){
        $this->ajaxReturn(array('msg' => '参数错误','status'=> 0),'json');
    }
    $param['resume_id'] = I('get.resume_id');
    $id = I('get.id');
    if (empty($param['resume_id'])||empty($id)){
    	 $this->ajaxReturn(array('msg' => '参数错误','status'=> 0),'json');
    }
    $url = get_api_info("resume","school/reward/list"); //获取路由地址
    $res = request_api($url,$param,"get"); //请求
    if(empty($res)){
       $this->ajaxReturn(array('msg' => '内容为空','status'=> 0),'json');
    }
    foreach($res as $k => $v){
    	if ($v['id'] == $id){
    		$res = $res[$k];
    	}
    }
	    $res['syear'] = (int)substr($res['get_time'],0,4);
	    $res['smonth'] = (int)substr($res['get_time'],4,2);
    	$data['msg'] =  "获取成功";
		$data['status'] =1;
		$data['info'] =	$res;
		$this->ajaxReturn($data,'json');
		
}

/**
* @desc 获取校内社会实践
* @author zhuyi
* @date 2016-07-02
*/
public function Get_Practice(){
	$param['access_token'] = session('user.access_token');
    if (empty($param['access_token'])){
        $this->ajaxReturn(array('msg' => '参数错误','status'=> 0),'json');
    }
    $param['resume_id'] = I('get.resume_id');
    $id = I('get.id');
    if (empty($param['resume_id'])||empty($id)){
    	 $this->ajaxReturn(array('msg' => '参数错误','status'=> 0),'json');
    }
    $url = get_api_info("resume","school/practice/list"); //获取路由地址
    $res = request_api($url,$param,"get"); //请求
    if(empty($res)){
       $this->ajaxReturn(array('msg' => '内容为空','status'=> 0),'json');
    }
    foreach($res as $k => $v){
    	if ($v['id'] == $id){
    		$res = $res[$k];
    	}
    }
	    $res['syear'] = (int)substr($res['get_time'],0,4);
	    $res['smonth'] = (int)substr($res['get_time'],4,2);
    	$data['msg'] =  "获取成功";
		$data['status'] =1;
		$data['info'] =	$res;
		$this->ajaxReturn($data,'json');
		
}

 /**
 * @desc 获取校内职位
 * @author zhuyi
 * @date 2016-07-02
 */
public function Get_School_Job(){
	$param['access_token'] = session('user.access_token');
    if (empty($param['access_token'])){
        $this->ajaxReturn(array('msg' => '参数错误','status'=> 0),'json');
    }
    $param['resume_id'] = I('get.resume_id');
    $id = I('get.id');
    if (empty($param['resume_id'])||empty($id)){
    	 $this->ajaxReturn(array('msg' => '参数错误','status'=> 0),'json');
    }
    $url = get_api_info("resume","school/job/list"); //获取路由地址
    $res = request_api($url,$param,"get"); //请求
    if(empty($res)){
       $this->ajaxReturn(array('msg' => '内容为空','status'=> 0),'json');
    }
    foreach($res as $k => $v){
    	if ($v['id'] == $id){
    		$res = $res[$k];
    	}
    }
	    $res['syear'] = (int)substr($res['sdate'],0,4);
	    $res['smonth'] = (int)substr($res['sdate'],4,2);
	    $res['eyear'] = (int)substr($res['edate'],0,4);
	    $res['emonth'] = (int)substr($res['edate'],4,2);
    	$data['msg'] =  "获取成功";
		$data['status'] =1;
		$data['info'] =	$res;
		$this->ajaxReturn($data,'json');
}

 /**
 * @desc 获取社会实践
 * @author zhuyi
 * @date 2016-07-02
 */
public function Get_School_Practice(){
	$param['access_token'] = session('user.access_token');
    if (empty($param['access_token'])){
        $this->ajaxReturn(array('msg' => '参数错误','status'=> 0),'json');
    }
    $param['resume_id'] = I('get.resume_id');
    $id = I('get.id');
    if (empty($param['resume_id'])||empty($id)){
    	 $this->ajaxReturn(array('msg' => '参数错误','status'=> 0),'json');
    }
    $url = get_api_info("resume","school/practice/list"); //获取路由地址
    $res = request_api($url,$param,"get"); //请求
    if(empty($res)){
       $this->ajaxReturn(array('msg' => '内容为空','status'=> 0),'json');
    }
    foreach($res as $k => $v){
    	if ($v['id'] == $id){
    		$res = $res[$k];
    	}
    }
	    $res['syear'] = (int)substr($res['sdate'],0,4);
	    $res['smonth'] = (int)substr($res['sdate'],4,2);
	    $res['eyear'] = (int)substr($res['edate'],0,4);
	    $res['emonth'] = (int)substr($res['edate'],4,2);
    	$data['msg'] =  "获取成功";
		$data['status'] =1;
		$data['info'] =	$res;
		$this->ajaxReturn($data,'json');
}

/**
* @desc 一键修改求职意向
* @author zhuyi
* @date 2016-07-02
*/
public function yj_Update_intention(){
	$param['access_token'] = session('user.access_token');
    if (empty($param['access_token'])){
        $this->ajaxReturn(array('msg' => '参数错误','status'=> 0),'json');
    }
	$param['id'] = I("post.id");//求职意向ID
	//当城市不为不限时
	if(!empty(I("post.city_id"))){
	    $work_cities_id = explode('/',I("post.city_id"));
	    $work_cities_name =  explode('/',I("post.city_name"));
	    if (count($work_cities_id) == 3){
	    	$work_cities_id[2] = I("post.job_city_id");
	    	$work_cities_name[2] = I("post.job_city_name");
	    }else{
	    	array_push($work_cities_id,I("post.job_city_id"));
	    	array_push($work_cities_name,I("post.job_city_name"));

	    }
	    foreach($work_cities_id as $k =>$v){
	        $param['work_cities'][$k]['id'] = $v;
	        $param['work_cities'][$k]['name'] = $work_cities_name[$k];
	    }
	    $param['work_cities'] = json_encode($param['work_cities']);
	}
	//当行业不为不限时
	if(!empty(I("post.trade_id"))){
	    $trade_id =  explode('/',I("post.trade_id"));
	    $trade_name =  explode('/',I("post.trade_name"));
	    if (count($trade_id) == 3){
	    	$trade_id[2] = I("post.job_trade_id");
	    	$trade_name[2] = I("post.job_trade_name");
	    }else{
	    	array_push($trade_id,I("post.job_trade_id"));
	    	array_push($trade_name,I("post.job_trade_name"));

	    }
	    foreach($trade_id as $k =>$v){
	        $param['trades'][$k]['id'] = $v;
	        $param['trades'][$k]['name'] = $trade_name[$k];
	    }
	    $param['trades'] = json_encode($param['trades']);
	}

	$param['work_type'] = I("post.work_type");
	$param['week_workdays'] = I("post.week_workdays");
	$param['work_duration'] = I("post.work_duration")*30;
	$param['arrive_days'] = I("post.arrive_days");
	$url = get_api_info(1,'intention/update'); //获取路由地址
	$res = request_api($url,$param,'put'); //请求
	$data = array('res' => $res);
	if ($res['error_code'] != 'success'){
		$data['status'] = 0;
		$data['msg'] = $res['error_description'];
	}else{
		$data['status'] = 1;
		$data['msg'] = "操作成功";
	}
	$this->ajaxReturn($data,'json');
}



/**
* @desc 获取二级行业
* @author zhuyi
* @date 2016-07-02
*/
public function Get_Trade(){

	$param['pid'] = I('get.pid');
    $url = get_api_info(2,'trades'); //获取路由地址
    $res = request_api($url,$param,"get"); //请求
    $data['info'] = $res;
    if (empty($res)){
    	$data['status'] = 0;
		$data['msg'] = '获取失败,请重试';
    }else{
    	$data['status'] = 1;
		$data['msg'] = "操作成功";
    }

    $this->ajaxReturn($data,'json');
}

/**
* @desc 获取二级职能
* @author zhuyi
* @date 2016-07-02
*/
public function Get_Wfs(){
	
	$param['func_cid'] = I('get.id');
    $url = get_api_info(2,'wfs/by_cid'); //获取路由地址
    $res = request_api($url,$param,"get"); //请求
    $data['info'] = $res;
    if (empty($res)){
    	$data['status'] = 0;
		$data['msg'] = '获取失败,请重试';
    }else{
    	$data['status'] = 1;
		$data['msg'] = "操作成功";
    }

    $this->ajaxReturn($data,'json');
}

 /**
 * @desc 头像
 * @author zhuyi
 * @date 2016-07-02
 */
public function Up_Load(){
	//图片文件名
	$imginfo['name'] = I('post.filename');
	$x = I('post.pic_x');
	$y = I('post.pic_y');
	$w = I('post.pic_w');
	$h = I('post.pic_h');
    $path = $_SERVER['DOCUMENT_ROOT'].'/uploads/';
    $imginfo['ext'] = pathinfo($imginfo['name'], PATHINFO_EXTENSION);
    //echo $_SERVER['DOCUMENT_ROOT'].$imginfo['name'];
    //裁剪
    $avatar_path = $this->cropper($_SERVER['DOCUMENT_ROOT'].$imginfo['name'],$path.time()."_".mt_rand().".{$imginfo['ext']}",$x,$y,$w,$h);
    if(empty($avatar_path)){
    	$this->ajaxReturn(array('msg' => '图片不合法','status'=> 0),'json');
    }
    // 实例化Public类
    $Public = A("Public");  
    $res = $Public->uploadPicApi($avatar_path);
    //print_r($res);
    
    if (!isset($res['file_id'])){
		$data['status'] = 0;
		$data['msg'] = "上传失败";
	}else{
		$data = array('file_id' => $res['file_id'],'path'=>$res['path']);
		$data['status'] = 1;
		$data['msg'] = "上传成功";
	}
	$this->ajaxReturn($data,'json');
}

 /**
 * @desc 反馈通知
 * @author zhuyi
 * @date 2016-07-02
 */
public function Message_Reply(){
	$param['access_token'] = session('user.access_token');
    if (empty($param['access_token'])){
        $this->ajaxReturn(array('msg' => '参数错误','status'=> 0),'json');
    }
	$param['id'] = I("post.id");//会话ID
	$param['event_id'] = I("post.event_id");//事件ID
    $url = get_api_info("post",'notice/message/reply'); //获取路由地址
    $res = request_api($url,$param,'post'); //上传
		$data = array('res' => $res);
	if ($res['error_code'] != 'success'){
		$data['status'] = 0;
		$data['msg'] = $res['error_description'];
	}else{
		$data['status'] = 1;
		$data['msg'] = "操作成功";
	}
	$this->ajaxReturn($data,'json');
}


/**
* @desc 获取简历下载地址
* @author zhuyi
* @date 2016-07-02
*/
public function Get_Resume_file(){
	$param['access_token'] = session('user.access_token');
	$param['resume_id'] = I('post.resume_id');
	$param['format'] = I('post.format','pdf');
    if (empty($param['access_token'])||empty($param['resume_id'])){
        $this->ajaxReturn(array('msg' => '参数错误','status'=> 0),'json');
    }
    //获取下载简历链接
    $url = get_api_info('resume','down'); //获取路由地址
    $file = request_api($url,$param,'get'); //获取简历文件下载链接
	if ($file['error_code'] != 'success'){
		$data['status'] = 0;
		$data['msg'] = $file['error_description'];
	}else{
		$data['info'] = $file['result'];
		$data['status'] = 1;
		$data['msg'] = "获取成功";
	}
	$this->ajaxReturn($data,'json');
}



/**
* @desc 反馈通知数量
* @author zhuyi
* @date 2016-09-29
*/
public function Feedback_Msg(){
	$param['access_token'] = session('user.access_token');
    if (empty($param['access_token'])){
        $this->ajaxReturn(array('msg' => '参数错误','status'=> 0),'json');
    }
    $op = I('post.op');
    switch ($op) {
    	case 'readdeliver':
		    //反馈消息数量
		    $param['deliver_id'] = I('post.deliver_id');
		    $url = get_api_info('post','user/readdeliver');
		    $res = request_api($url,$param,'post');
    		break;

    	case 'readrecommend':
    		//更新推送岗位消息数量
		    $url = get_api_info('post','user/readrecommend');
		    $res = request_api($url,$param,'post');
    		break;

    	default:
    		# code...
    		break;
    }

	if ($res['error_code'] != 'success'){
		$data['status'] = 0;
		$data['msg'] = '失败';
	}else{
		$data['status'] = 1;
		$data['msg'] = "成功";
	}
	$this->ajaxReturn($data,'json');
}

/**
* @desc 获取通知数量
* @author zhuyi
* @date 2016-09-29
*/
public function Get_Msg(){
	//获取通知数量
	 $res = _get_notice();
	//写入session
	session('message_num',$res);
	if (empty($res)){
		$data['status'] = 0;
		$data['msg'] = '失败';
	}else{
		session('message_num',$res);
		$data['info'] = $res;
		$data['status'] = 1;
		$data['msg'] = "成功";
	}

	$this->ajaxReturn($data,'json');
}

/**
* @desc 设置cookies
* @author zhuyi
* @date 2016-11-14
*/
public function Setcookies(){
    if (empty(session('user.access_token'))){
        $this->ajaxReturn(array('msg' => '参数错误','status'=> 0),'json');
    }
	$name = I('get.name');
	cookie($name,1);
}

/**
* @desc 消息通知操作
* @param  id|op[sc,td][删除，投递]
* @author zhuyi
* @date 2016-09-29
*/
public function Message_Center_Op(){
	$param['access_token'] = session('user.access_token');
	$op = I('post.op');
    if (empty($param['access_token'])){
        $this->ajaxReturn(array('msg' => '参数错误','status'=> 0),'json');
    }
    switch ( $op ) {//批量删除
    	case 'sc':
		    //操作
		    $param['ids'] = trim(I('post.id'),',');
		    if ( empty($param['ids'] )){
		        $this->ajaxReturn(array('msg' => '参数错误','status'=> 0),'json');
		    }
		    $url = get_api_info('post','user/recommend');
		    $res = request_api($url,$param,'delete');
    		break;
    	case 'td'://批量投递
    		//操作
		    $param['post_ids'] = trim(I('post.post_ids'),',');
		    $param['resume_id'] = I('post.resume_id');
		    $param['device'] = 1;//PC端投递
		    if (empty($param['post_ids']) || empty($param['resume_id'])){
		        $this->ajaxReturn(array('msg' => '参数错误','status'=> 0),'json');
		    }
		    $url = get_api_info('post','batch_deliver');
		    $res = request_api($url,$param,'post');	
		    //print_r($res);
    		break;
    	default:
    		$this->ajaxReturn(array('msg' => '参数错误','status'=> 0),'json');
    		break;
    }

	if ( $res['error_code'] != 'success' ){
		$data['status'] = 0;
		$data['msg'] = $res['error_description'];
	}else{
		$data['status'] = 1;
		$data['msg'] = "操作成功";
	}
	$this->ajaxReturn($data,'json');
}



}