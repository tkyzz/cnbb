<?php
//author zhuyi
namespace Home\Controller;
use Think\Controller;
class StudentAjaxController extends \Components\BaseController {

 /**
 * @desc 构造
 * @author zhuyi
 * @date 2016-07-02
 */
public function __construct(){
    parent::__construct();
    $this->assign('navclass','student');
   // if(!check_login()){
   //     $this->ajaxReturn(array('msg' => '请登录！','status'=> 0),'json');
   //  }

}

 /**
 * @desc 简历--个人信息OB
 * @author zhuyi
 * @date 2016-09-20
 */
public function Ajax_BaseInfo(){
	$param['access_token'] = session("user.access_token");
	$url_id = substr(base64_decode(I('post.id')),6);
	if (empty($param['access_token'])){
		$this->ajaxReturn(array('msg' => '请登录！','status'=> 0),'json');
	}
	$param['id'] = $url_id;
	$url = get_api_info(1,'detail/'.$param['id']); //获取路由地址
	$res = request_api($url,$param,'get'); //获取简历详情
	if(empty($res)){
		$this->ajaxReturn(array('msg' => '没有获得信息！','status'=> 0),'json');
	}
	$this->assign('res',$res);
	$this->assign('info',$res['info']);//个人信息
    $data['html'] = $this->fetch("ajax_resumeInfo");
	$data['msg'] = "success";
	$data['status'] =1;
	$this->ajaxReturn($data,'json');

}

 /**
 * @desc 简历--教育经历OB
 * @author zhuyi
 * @date 2016-09-20
 */
public function Ajax_Edu(){
	$param['access_token'] = session("user.access_token");
	$url_id = substr(base64_decode(I('post.id')),6);
	if (empty($param['access_token'])){
		$this->ajaxReturn(array('msg' => '请登录！','status'=> 0),'json');
	}
	$param['id'] = $url_id;
	$url = get_api_info(1,'detail/'.$param['id']); //获取路由地址
	$res = request_api($url,$param,'get'); //获取简历详情
	if(empty($res)){
		$this->ajaxReturn(array('msg' => '没有获得信息！','status'=> 0),'json');
	}
	$this->assign('edus',$res['edus']);
    $data['edu_html'] = $this->fetch("ajax_resumeEdu");//教育经历
    $data['exchange_html'] = $this->fetch("ajax_resumeEduexchange");//交换生经历
    $data['project_html'] = $this->fetch("ajax_resumeEduproject");//项目经历
	$data['msg'] = "success";
	$data['status'] =1;
	$this->ajaxReturn($data,'json');

}


 /**
 * @desc 简历--技能OB
 * @author zhuyi
 * @date 2016-09-20
 */
public function Ajax_Skill(){
	$param['access_token'] = session("user.access_token");
	$url_id = substr(base64_decode(I('post.id')),6);
	if (empty($param['access_token'])){
		$this->ajaxReturn(array('msg' => '请登录！','status'=> 0),'json');
	}
	$param['id'] = $url_id;
	$url = get_api_info(1,'detail/'.$param['id']); //获取路由地址
	$res = request_api($url,$param,'get'); //获取简历详情
	if(empty($res)){
		$this->ajaxReturn(array('msg' => '没有获得信息！','status'=> 0),'json');
	}
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
    		//$res['skill']['enskill'] .= '；';
    	}
    }
	$this->assign('res',$res);
	$this->assign('skill',$res['skill']);//技能
    $data['html'] = $this->fetch("ajax_resumeSkill");
	$data['msg'] = "获取成功！";
	$data['status'] =1;
	$this->ajaxReturn($data,'json');

}


 /**
 * @desc 简历--证书OB
 * @author zhuyi
 * @date 2016-09-20
 */
public function Ajax_Cert(){
	$param['access_token'] = session("user.access_token");
	$url_id = substr(base64_decode(I('post.id')),6);
	if (empty($param['access_token'])){
		$this->ajaxReturn(array('msg' => '请登录！','status'=> 0),'json');
	}
	$param['id'] = $url_id;
	$url = get_api_info(1,'detail/'.$param['id']); //获取路由地址
	$res = request_api($url,$param,'get'); //获取简历详情
	if(empty($res)){
		$this->ajaxReturn(array('msg' => '没有获得信息！','status'=> 0),'json');
	}
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
	$this->assign('res',$res);
	$this->assign('certificates',$res['certificates']);//证书
    $data['html'] = $this->fetch("ajax_resumeCert");
	$data['msg'] = "获取成功！";
	$data['status'] =1;
	$this->ajaxReturn($data,'json');

}

 /**
 * @desc 简历--实习经验OB
 * @author zhuyi
 * @date 2016-09-20
 */
public function Ajax_Internship(){
	$param['access_token'] = session("user.access_token");
	$url_id = substr(base64_decode(I('post.id')),6);
	if (empty($param['access_token'])){
		$this->ajaxReturn(array('msg' => '请登录！','status'=> 0),'json');
	}
	$param['id'] = $url_id;
	$url = get_api_info(1,'detail/'.$param['id']); //获取路由地址
	$res = request_api($url,$param,'get'); //获取简历详情
	if(empty($res)){
		$this->ajaxReturn(array('msg' => '没有获得信息！','status'=> 0),'json');
	}
	$this->assign('res',$res);
	$this->assign('internships',$res['internships']);//实习经历
    $data['html'] = $this->fetch("ajax_resumeInternship");
	$data['msg'] = "获取成功！";
	$data['status'] =1;
	$this->ajaxReturn($data,'json');

}

 /**
 * @desc 简历--校内经历OB
 * @author zhuyi
 * @date 2016-09-20
 */
public function Ajax_Xnjl(){
	$param['access_token'] = session("user.access_token");
	$url_id = substr(base64_decode(I('post.id')),6);
	if (empty($param['access_token'])){
		$this->ajaxReturn(array('msg' => '请登录！','status'=> 0),'json');
	}
	$param['id'] = $url_id;
	$url = get_api_info(1,'detail/'.$param['id']); //获取路由地址
	$res = request_api($url,$param,'get'); //获取简历详情
	if(empty($res)){
		$this->ajaxReturn(array('msg' => '没有获得信息！','status'=> 0),'json');
	}
	$this->assign('rjp',$res['rjp']);//校内经历
    $data['reward_html'] = $this->fetch("ajax_resumeReward");
    $data['jobs_html'] = $this->fetch("ajax_resumeJobs");
    $data['practice_html'] = $this->fetch("ajax_resumePractice");
	$data['msg'] = "success";
	$data['status'] =1;
	$this->ajaxReturn($data,'json');

}

 /**
 * @desc 更新简历(聚合操作)
 * @author zhuyi
 * @date 2016-07-02
 */
public function Update_Resume(){
	$param['access_token'] = session("user.access_token");
	if (empty($param['access_token'])){
		$this->error("非法操作",U('user/login'));exit;
	}
	if(IS_POST){
		$op_time = time();
		$type = I("post.type");
		if (empty($type)){
			$this->ajaxReturn(array('status' => 0,'msg'=>'非法操作'),'json');
		}
		if (time() - session('op_time') < 3){
			$this->ajaxReturn(array('status' => -1,'msg'=>'操作太频繁了，请稍等一下吧。。。'),'json');
		}
		switch ($type) {
			case 'base_create'://个人信息创建
				$param['resume_id'] = I("post.resume_id");
				$param['avatar_id'] = I("post.avatar_id");
				$param['full_name'] = I("post.full_name");
				$param['gender'] = I("post.gender");
				$param['mobile'] = I("post.mobile");
				$param['email'] = I("post.email");
				$param['birthday'] = I("post.birthday");
				$param['province_id'] = I("post.province_id");
				$param['city_id'] = I("post.city_id");
				$param['hk_type'] = I("post.hk_type");
				$param['hk_province_id'] = I("post.hk_province_id");
				$param['hk_city_id'] = I("post.hk_city_id");
				$param['politics'] = I("post.politics");
				$param['card_type'] = I("post.card_type");
				$param['card_no'] = I("post.card_no");
				$param['height'] = I("post.height")/100;
				$param['weight'] = I("post.weight");
				$param['tags'] = I("post.tags");
				$param['address'] = I("post.address");
                $param['birthday'] = str_replace('-','',$param['birthday']);
				$url = get_api_info(1,'base/create'); //获取路由地址
				$res = request_api($url,$param,'post'); //请求
				break;
			case 'base_update'://个人信息更新
			    $param['id'] = I("post.id");
				$param['avatar_id'] = I("post.avatar_id");
				$param['full_name'] = I("post.full_name");
				$param['gender'] = I("post.gender");
				$param['mobile'] = I("post.mobile");
				$param['email'] = I("post.email");
				$param['birthday'] = I("post.birthday");
				$param['province_id'] = I("post.province_id");
				$param['city_id'] = I("post.city_id");
				$param['hk_type'] = I("post.hk_type");
				$param['hk_province_id'] = I("post.hk_province_id");
				$param['hk_city_id'] = I("post.hk_city_id");
				$param['politics'] = I("post.politics");
				$param['card_type'] = I("post.card_type");
				$param['card_no'] = I("post.card_no");
				$param['height'] = I("post.height")/100;
				$param['weight'] = I("post.weight");
                $param['stags'] = I("post.stags");
				$param['tags'] = I("post.tags");
				$param['address'] = I("post.address");
                $param['birthday'] = str_replace('-','',$param['birthday']);
				$url = get_api_info(1,'base/update'); //获取路由地址
				$res = request_api($url,$param,'put'); //请求
				break;
			case 'intention_create'://求职意向创建
				$param['resume_id'] = I("post.resume_id");
				
                $work_cities_id = explode('/',I("post.work_cities_id"));
                $work_cities_name =  explode('/',I("post.work_cities_name"));
	            if(!empty($work_cities_id)){
	                foreach($work_cities_id as $k =>$v){
	                    $param['work_cities'][$k]['id'] = $v;
	                    $param['work_cities'][$k]['name'] = $work_cities_name[$k];
	                }
	                $param['work_cities'] = json_encode($param['work_cities'],JSON_UNESCAPED_UNICODE);
            	}
            	
                $trade_id =  explode('/',I("post.trade_id"));
                $trade_name =  explode('/',I("post.trade_name"));
	            if(!empty($trade_id)){
	                foreach($trade_id as $k =>$v){
	                    $param['trades'][$k]['id'] = $v;
	                    $param['trades'][$k]['name'] = $trade_name[$k];
	                }
	                
	                $param['trades'] = json_encode($param['trades'],JSON_UNESCAPED_UNICODE);
            	}
				$param['work_type'] = I("post.work_type");
				$param['week_workdays'] = I("post.week_workdays");
                if (I("post.duration")==1){
                    $param['work_duration'] = 0;
                }else{
                    $param['work_duration'] = I("post.work_duration")*30;
                }
				$param['arrive_days'] = I("post.arrive_days");
	            //去除没有内容的变量
	            foreach($param as $k => $v){
	                if(!isset($param[$k])){
	                    unset($param[$k]);
	                }
	            }
				$url = get_api_info(1,'intention/create'); //获取路由地址
				$res = request_api($url,$param,'post'); //请求
				break;
			case 'intention_update'://求职意向更新
				$param['id'] = I("post.id");
				$work_cities_id = explode('/',I("post.work_cities_id"));
	            $work_cities_name =  explode('/',I("post.work_cities_name"));
				if(!empty($work_cities_id)){

	                foreach($work_cities_id as $k =>$v){
	                    $param['work_cities'][$k]['id'] = $v;
	                    $param['work_cities'][$k]['name'] = $work_cities_name[$k];
	                }
	                $param['work_cities'] = json_encode($param['work_cities'],JSON_UNESCAPED_UNICODE);
	            }
	                $trade_id =  explode('/',I("post.trade_id"));
	                $trade_name =  explode('/',I("post.trade_name"));
	            if(!empty($trade_id)){    
	                foreach($trade_id as $k =>$v){
	                    $param['trades'][$k]['id'] = $v;
	                    $param['trades'][$k]['name'] = $trade_name[$k];
	                }
	            	$param['trades'] = json_encode($param['trades'],JSON_UNESCAPED_UNICODE);
                }
				$param['work_type'] = I("post.work_type");
				$param['week_workdays'] = I("post.week_workdays");
                if (I("post.duration")==1){
                    $param['work_duration'] = 0;
                }else{
                    $param['work_duration'] = I("post.work_duration")*30;
                }
				$param['arrive_days'] = I("post.arrive_days");
	            //去除没有内容的变量
	            foreach($param as $k => $v){
	                if(!isset($param[$k])){
	                    unset($param[$k]);
	                }
	            }
                //print_r($param);
				$url = get_api_info(1,'intention/update'); //获取路由地址
				$res = request_api($url,$param,'put'); //请求
				break;
			case 'edu_create'://教育经历创建
                $syear = I("post.syear");
                $smonth = I("post.smonth");
                $eyear = I("post.eyear");
                $emonth = I("post.emonth");
                if (strlen($smonth) == 1){//格式是20100117
                    $param['sdate'] =  $syear.'0'.$smonth;//开始时间 
                }else{
                    $param['sdate'] =  $syear.$smonth;//开始时间 
                }
                if ($eyear * $emonth !=0){//当毕业时间为空自动转为至今
                    if (strlen($emonth) == 1){//格式是20100117
                        $param['edate'] =  $eyear.'0'.$emonth;//开始时间 
                    }else{
                        $param['edate'] =  $eyear.$emonth;//开始时间 
                    }
                }else{
                    $param['edate'] = '0';
                }
                $param['resume_id'] =  I("post.resume_id");//简历id
                $param['grade'] = I("post.syear");//年级
                $param['bp'] = I("post.bp");//绩点
                $param['degree'] = I("post.degree");//学历
                $param['rank'] = I("post.rank");//排名
                $param['faculty'] = I("post.faculty");//院系
                $param['major'] = I("post.major");//专业名称
                $param['major_cid'] = I("post.major_category_id");//专业类id
                $param['major_category_name'] = I("post.major_category_name");//专业类名称
                $param['school_province_code'] = I("post.school_provid");//学校省
                $param['school_id'] = I("post.school_id");//学校ID
                $param['school_name'] = I("post.school_name");//学校名称
                if (!empty(I("post.second_major"))){
                    $param['second_major'] = I("post.second_major");//第二专业名称
                    $param['second_major_cid'] = I("post.second_major_category_id");//第二专业类id
                    $param['second_major_category_name'] = I("post.second_major_category_name");//第二专业类名称
                }
                foreach($param as $k => $v){
                    if($v ==""){
                        unset($param[$k]);
                    }
                }
                $url = get_api_info(1,'edu/create'); //获取路由地址
                $res = request_api($url,$param,'post'); //创建教育经历
				break;
			case 'edu_update': //教育经历更新
                $syear = I("post.syear");
                $smonth = I("post.smonth");
                $eyear = I("post.eyear");
                $emonth = I("post.emonth");
                if (strlen($smonth) == 1){//格式是20100117
                    $param['sdate'] =  $syear.'0'.$smonth;//开始时间 
                }else{
                    $param['sdate'] =  $syear.$smonth;//开始时间 
                }
                if ($eyear * $emonth !=0){//当毕业时间为空自动转为至今
                    if (strlen($emonth) == 1){//格式是20100117
                        $param['edate'] =  $eyear.'0'.$emonth;//结束时间 
                    }else{
                        $param['edate'] =  $eyear.$emonth;//结束时间 
                    }
                }else{
                    $param['edate'] = '0';
                }
                $param['edu_id'] = I("post.edu_id");//教育经历ID
                $param['grade'] = I("post.syear");//年级
                $param['bp'] = I("post.bp",0);//绩点
                $param['degree'] = I("post.degree");//学历
                $param['rank'] = I("post.rank",0);//排名
                $param['faculty'] = I("post.faculty");//院系
                $param['major'] = I("post.major");//专业名称
                $param['major_cid'] = I("post.major_category_id");//专业类id
                $param['major_category_name'] = I("post.major_category_name");//专业类名称
                $param['school_id'] = I("post.school_id");//学校ID
                $param['school_name'] = I("post.school_name");//学校名称
                $param['school_province_code'] = I("post.school_provid");//学校省
                if (!empty(I("post.second_major"))){
                    $param['second_major'] = I("post.second_major");//第二专业名称
                    $param['second_major_cid'] = I("post.second_major_category_id");//第二专业类id
                    $param['second_major_category_name'] = I("post.second_major_category_name");//第二专业类名称
                }
                foreach($param as $k => $v){
                    if($v ==""){
                        unset($param[$k]);
                    }
                }
                $url = get_api_info(1,'edu/update'); //获取路由地址
                $res = request_api($url,$param,'put'); //更新教育经历
				break;
			case 'edu_del'://教育经历删除
                $param['edu_id'] = I("post.edu_id");//教育经历ID
                $url = get_api_info(1,'edu/del'); //获取路由地址
                $res = request_api($url,$param,'delete'); //删除教育经历
				break;
			case 'edu_exchange_create'://新增交换生经历
                $syear = I("post.syear");
                $smonth = I("post.smonth");
                $eyear = I("post.eyear");
                $emonth = I("post.emonth");
                if (strlen($smonth) == 1){//格式是20100117
                    $param['sdate'] =  $syear.'0'.$smonth;//开始时间 
                }else{
                    $param['sdate'] =  $syear.$smonth;//开始时间 
                }
                if ($eyear * $emonth !=0){//当毕业时间为空自动转为至今
                    if (strlen($emonth) == 1){//格式是20100117
                        $param['edate'] =  $eyear.'0'.$emonth;//结束时间 
                    }else{
                        $param['edate'] =  $eyear.$emonth;//结束时间 
                    }
                }else{
                    $param['edate'] = 0;
                }
                $param['edu_id'] = I("post.edu_id");//教育经历ID
                if(empty($param['edu_id'])){
                	$this->ajaxReturn(array('msg' => "请选择教育经历中的学校",'status'=> 0),'json');
                }
                $param['country_code'] = I("post.country_code");//国家ID
                //$param['school_province_code'] = I("post.school_province_code");//学校省id
                $param['school_name'] = I("post.school_name");//学校名称
                $param['major_cid'] = I("post.major_cid");//专业分类id
                $param['major'] = I("post.major");//专业
                $param['remark'] = I("post.remark");//描述
                $url = get_api_info(1,'edu/exchange/create'); //获取路由地址
                $res = request_api($url,$param,'post'); //删除教育经历
				break;
            case 'edu_exchange_update'://更新交换生经历
                $syear = I("post.syear");
                $smonth = I("post.smonth");
                $eyear = I("post.eyear");
                $emonth = I("post.emonth");
                if (strlen($smonth) == 1){//格式是20100117
                    $param['sdate'] =  $syear.'0'.$smonth;//开始时间 
                }else{
                    $param['sdate'] =  $syear.$smonth;//开始时间 
                }
                if ($eyear * $emonth !=0){//当毕业时间为空自动转为至今
                    if (strlen($emonth) == 1){//格式是20100117
                        $param['edate'] =  $eyear.'0'.$emonth;//结束时间 
                    }else{
                        $param['edate'] =  $eyear.$emonth;//结束时间 
                    }
                }else{
                    $param['edate'] = 0;
                }
                $param['id'] = I("post.id");//交换生ID
                $param['country_code'] = I("post.country_code");//国家ID
               // $param['school_province_code'] = I("post.school_province_code");//学校省id
                //$param['school_id'] = I("post.school_id");//学校id
                $param['school_name'] = I("post.school_name");//学校名称
                $param['major_cid'] = I("post.major_cid");//专业分类id
                $param['major'] = I("post.major");//专业
                $param['remark'] = I("post.remark");//描述
                $url = get_api_info(1,'edu/exchange/update'); //获取路由地址
                $res = request_api($url,$param,'put'); //删除教育经历
                break; 
            case 'edu_exchange_del'://删除交换生经历
                $param['id'] = I("post.id");//交换生ID
                $url = get_api_info(1,'edu/exchange/del'); //获取路由地址
                $res = request_api($url,$param,'delete'); //删除交换生经历
                break;
            case 'edu_ex_create'://专业项目研究新增
                $syear = I("post.syear");
                $smonth = I("post.smonth");
                $eyear = I("post.eyear");
                $emonth = I("post.emonth");
                if (strlen($smonth) == 1){//格式是20100117
                    $param['sdate'] =  $syear.'0'.$smonth;//开始时间 
                }else{
                    $param['sdate'] =  $syear.$smonth;//开始时间 
                }
                if ($eyear * $emonth !=0){//当毕业时间为空自动转为至今
                    if (strlen($emonth) == 1){//格式是20100117
                        $param['edate'] =  $eyear.'0'.$emonth;//结束时间 
                    }else{
                        $param['edate'] =  $eyear.$emonth;//结束时间 
                    }
                }else{
                    $param['edate'] = 0;
                }
                $param['edu_id'] = I("post.edu_id");//教育经历ID
                $param['name'] = I("post.name");//项目名称
                $param['role'] = I("post.role");//角色
                $param['remark'] = I("post.remark");//描述
                $url = get_api_info(1,'edu/ex/create'); //获取路由地址
                $res = request_api($url,$param,'post'); //提交新增专业项目研究
                break;
            case 'edu_ex_update'://专业项目研究更新
                $syear = I("post.syear");
                $smonth = I("post.smonth");
                $eyear = I("post.eyear");
                $emonth = I("post.emonth");
                if (strlen($smonth) == 1){//格式是20100117
                    $param['sdate'] =  $syear.'0'.$smonth;//开始时间 
                }else{
                    $param['sdate'] =  $syear.$smonth;//开始时间 
                }
                if ($eyear * $emonth !=0){//当毕业时间为空自动转为至今
                    if (strlen($emonth) == 1){//格式是20100117
                        $param['edate'] =  $eyear.'0'.$emonth;//结束时间 
                    }else{
                        $param['edate'] =  $eyear.$emonth;//结束时间 
                    }
                }else{
                    $param['edate'] = 0;
                }
                $param['id'] = I("post.id");//研究ID
                $param['name'] = I("post.name");//项目名称
                $param['role'] = I("post.role");//角色
                $param['remark'] = I("post.remark");//描述
                $url = get_api_info(1,'edu/ex/update'); //获取路由地址
                $res = request_api($url,$param,'put'); //提交新增专业项目研究
                break;
            case 'edu_ex_del':
                $param['id'] = I("post.id");//研究ID
                $url = get_api_info(1,'edu/ex/del'); //获取路由地址
                $res = request_api($url,$param,'delete'); //删除指定的专业项目经历
                break;
            case 'skill_create':
                $param['resume_id'] = I("post.resume_id");//简历ID
                $param['en'] = I("post.en",-1);//英语水平枚举值
               	$param['englishscore'] = I("post.englishscore",-1);//英语分数
               	if(empty($param['englishscore'])){
               		$param['englishscore'] = -1;
               	}
               	$othername = I('post.name');//其他技能名称
               	$otherproficiency = I('post.proficiency');
               	if(I("post.toefl") == 1){
               		$param['toefl'] = I("post.toeflscore");//托福
               		if(!isset($param['toefl'])){
						$param['toefl'] = -1;//托福
               		}
               		
               	}
               	if(!isset($param['toefl'])){
               		$param['toefl'] = 0;
               	}
               	if(I("post.ielts") == 1){
               		$param['ielts'] = I("post.ieltsscore",-1);//雅思
               		if(!isset($param['ielts'])){
						$param['ielts'] = -1;//雅思
               		}
               		$param['ielts'] = I("post.ieltsscore",-1);//IELTS雅思
               	}
               	if(!isset($param['ielts'])){
               		$param['ielts'] = 0;
               	}
               	if($param['en'] == 0 && $param['englishscore'] > 720){
               		$this->ajaxReturn(array('msg' => "超过了英语四级的最高分数",'status'=> 0),'json');
               	}
				if( count($othername) >1 ){
					$arr = array_count_values($othername);
				}
				//var_dump($arr);
				foreach ($arr as $v) {
					if($v >1){
						$this->ajaxReturn(array('msg' => "请不要选择相同的其他技能",'status'=> 0),'json');
					}
				}
				$param['other_langs'] = array();
                foreach($othername as $k => $v){

	                if ($v != ''){
	                	if($otherproficiency[$k] == ''){
	                		$this->ajaxReturn(array('msg' => "请选择{$v}的熟练程度",'status'=> 0),'json');
	                	}
	                	$param['other_langs'][] = array('ex1'=>0,'ex2'=>0,'ex3'=>0,'id'=>0,'skill_id'=>0,'literacy'=> 0,'lwability'=>0,'name'=>$v,'proficiency'=>$otherproficiency[$k]);
	                }
                }
                // $param['gre'] = I("post.gre");//GRE
                // $param['gmat'] = I("post.gmat");//GMAT
                // $param['TOEIC'] = I("post.TOEIC");//TOEIC
                // $param['other'] = I("post.other");//TOEIC
                $param['other_langs'] = json_encode($param['other_langs'],JSON_UNESCAPED_UNICODE);
                //$param['other'] = I("post.other");//其他技能
                //print_r($param);die();
                $url = get_api_info(1,'skill/create'); //获取路由地址
                $res = request_api($url,$param,'post'); //删除指定的专业项目经历
                break;
            case 'skill_update':
                $param['id'] = I("post.skill_id");//技能ID
                $param['en'] = I("post.en",-1);//英语水平枚举
               	$param['englishscore'] = I("post.englishscore");//英语分数
               	if(empty($param['englishscore'])){
               		$param['englishscore'] = -1;
               	}
               	$othername = I('post.name');//其他技能名称
               	$otherproficiency = I('post.proficiency');
               	if(I("post.toefl") == 1){
               		$param['toefl'] = I("post.toeflscore");//托福
               	}else{
               		$param['toefl'] = 0;
               	}
               	if(!isset($param['toefl'])){
               		$param['toefl'] = -1;
               	}
               	if(I("post.ielts") == 1){
               		$param['ielts'] = I("post.ieltsscore");//IELTS雅思
               	}else{
               		$param['ielts'] = 0;
               	}
               	if(!isset($param['ielts'])){
               		$param['ielts'] = -1;
               	}
               	if($param['en'] == 0 && $param['englishscore'] > 710){
               		$this->ajaxReturn(array('msg' => "超过了大学英语四级的最高分数710分",'status'=> 0),'json');
               	}
               	if($param['en'] == 1 && $param['englishscore'] > 710){
               		$this->ajaxReturn(array('msg' => "超过了大学英语六级的最高分数710分",'status'=> 0),'json');
               	}
               	if($param['en'] == 2 && $param['englishscore'] > 100){
               		$this->ajaxReturn(array('msg' => "超过了专业四级的最高分数100分",'status'=> 0),'json');
               	}
               	if($param['en'] == 3 && $param['englishscore'] > 100){
               		$this->ajaxReturn(array('msg' => "超过了专业六级的最高分数100分",'status'=> 0),'json');
               	}
               	if($param['en'] == 4 && $param['englishscore'] > 100){
               		$this->ajaxReturn(array('msg' => "超过了专业八级的最高分数100分",'status'=> 0),'json');
               	}
                // $param['gre'] = I("post.gre");//GRE
                // $param['gmat'] = I("post.gmat");//GMAT
                // $param['TOEIC'] = I("post.TOEIC");//TOEIC
                //$param['other'] = I("post.other");//其他技能
				if( count($othername) >1 ){
					$arr = array_count_values($othername);
				}
				//var_dump($arr);
				foreach ($arr as $k => $v) {
					if(!empty($k) && $v >1){
						$this->ajaxReturn(array('msg' => "请不要选择相同的其他技能",'status'=> 0),'json');
					}
				}
				$param['other_langs'] = array();
                foreach($othername as $k => $v){
	                if ($v != ''){
	                	if($otherproficiency[$k] == ''){
	                		$this->ajaxReturn(array('msg' => "请选择{$v}的熟练程度",'status'=> 0),'json');
	                	}
	                	$param['other_langs'][] = array('ex1'=>0,'ex2'=>0,'ex3'=>0,'id'=>0,'skill_id'=>0,'literacy'=> 0,'lwability'=>0,'name'=>$v,'proficiency'=>$otherproficiency[$k]);
	                }
                }

                // if (I("post.name2")!=''){
                // $param['other_langs'][] = array('ex1'=>0,'ex2'=>0,'ex3'=>0,'id'=>0,'skill_id'=>0,'literacy'=> I("post.literacy2"),'lwability'=>I("post.lwability2"),'name'=>I("post.name2"),'proficiency'=>I("post.proficiency2"));
                // }
                // if (I("post.jsjproficiency") != ''){
                // $param['other_langs'][] = array('ex1'=>0,'ex2'=>0,'ex3'=>0,'id'=>0,'skill_id'=>0,'literacy'=> 0,'lwability'=>0,'name'=>'计算机','proficiency'=>I("post.jsjproficiency"));//计算机技能
                // }
                $param['other_langs'] = json_encode($param['other_langs'],JSON_UNESCAPED_UNICODE);
                //print_r($param);die();
                $url = get_api_info(1,'skill/update'); //获取路由地址
                $res = request_api($url,$param,'put'); //删除指定的专业项目经历
                break;
            case 'skill_del':
                $param['id'] = I("post.id");//技能ID
                $url = get_api_info(1,'skill/del'); //获取路由地址
                $res = request_api($url,$param,'delete'); //删除指定的专业项目经历
                break;
            case 'cert_create':
                $param['resume_id'] = I("post.resume_id");
                $param['cid'] = I("post.cid");
                $arr = explode(',',I("post.courses"));
                    if (in_array('all2',$arr)){
                        $param['allpass2'] = 'true';
                    }
                    if (in_array('all',$arr)){
                        $param['allpass'] = 'true';
                    }
                foreach($arr as $k=>$v){
                    if($v == 'all'||$v == 'all2'){
                        unset($arr[$k]);
                    }
                }
                $param['courses'] = implode(',',$arr);
                unset($arr);
                foreach($param as $k=>$v){
                    if($param[$k] == ''){
                        //echo $k;
                        unset($param[$k]);
                    }
                }
                //print_r($param);
                $url = get_api_info(1,'certificate/create'); //获取路由地址
                $res = request_api($url,$param,'post'); //创建证书
                break;
            case 'cert_update':
                $param['id'] = I("post.id");
                $arr = explode(',',I("post.courses"));
                if (in_array('all2',$arr)){
                        $param['allpass2'] = 'true';
                    }
                    if (in_array('all',$arr)){
                        $param['allpass'] = 'true';
                    }
                foreach($arr as $k=>$v){
                    if($v == 'all'||$v == 'all2'){
                        unset($arr[$k]);
                    }
                }
                $param['courses'] = implode(',',$arr);
                unset($arr);
                foreach($param as $k=>$v){
                    if($param[$k] == ''){
                        //echo $k;
                        unset($param[$k]);
                    }
                }
                $url = get_api_info(1,'certificate/update'); //获取路由地址
                $res = request_api($url,$param,'put'); //更新证书
                break;
            case 'cert_del':
                $param['id'] = I("post.id");
                $url = get_api_info(1,'certificate/del'); //获取路由地址
                $res = request_api($url,$param,'delete'); //删除证书
                break;
            case 'internship_create':
                $syear = I("post.syear");
                $smonth = I("post.smonth");
                $eyear = I("post.eyear");
                $emonth = I("post.emonth");
                if (strlen($smonth) == 1){//格式是20100117
                    $param['start_date'] =  $syear.'0'.$smonth;//开始时间 
                }else{
                    $param['start_date'] =  $syear.$smonth;//开始时间 
                }
                if ($eyear * $emonth !=0){//当毕业时间为空自动转为至今
                    if (strlen($emonth) == 1){//格式是20100117
                        $param['end_date'] =  $eyear.'0'.$emonth;//结束时间 
                    }else{
                        $param['end_date'] =  $eyear.$emonth;//结束时间 
                    }
                }else{
                    $param['end_date'] = 0;
                }
                $param['resume_id'] = I("post.resume_id");//简历ID
                $param['company_name'] = I("post.company_name");//公司名称
                $param['trade'] = I("post.trade");//行业ID
                $param['sub_trade'] = I("post.sub_trade");//二级行业ID
                $param['nature'] = I("post.nature");//公司性质
                $param['department'] = I("post.department");//部门
                $param['function'] = I("post.function");//职位
                $param['work_type'] = I("post.work_type");//工作类型
                $param['work_remark'] = I("post.work_remark");//工作描述
                $param['work_ex'] = I("post.work_ex");//工作项目经验
                $url = get_api_info(1,'internship/create'); //获取路由地址
                $res = request_api($url,$param,'post'); //新增实习经验
                break;
            case 'internship_update':
                $syear = I("post.syear");
                $smonth = I("post.smonth");
                $eyear = I("post.eyear");
                $emonth = I("post.emonth");
                if (strlen($smonth) == 1){//格式是20100117
                    $param['start_date'] =  $syear.'0'.$smonth;//开始时间 
                }else{
                    $param['start_date'] =  $syear.$smonth;//开始时间 
                }
                if ($eyear * $emonth !=0){//当毕业时间为空自动转为至今
                    if (strlen($emonth) == 1){//格式是20100117
                        $param['end_date'] =  $eyear.'0'.$emonth;//结束时间 
                    }else{
                        $param['end_date'] =  $eyear.$emonth;//结束时间 
                    }
                }else{
                    $param['end_date'] = 0;
                }
                $param['id'] = I("post.id");//实习经验ID
                $param['company_name'] = I("post.company_name");//公司名称
                $param['trade'] = I("post.trade");//行业ID
                $param['sub_trade'] = I("post.sub_trade");//二级行业ID
                $param['nature'] = I("post.nature");//公司性质
                $param['department'] = I("post.department");//部门
                $param['function'] = I("post.function");//职位
                $param['work_type'] = I("post.work_type");//工作类型
                $param['work_remark'] = I("post.work_remark");//工作描述
                $param['work_ex'] = I("post.work_ex");//工作项目经验
                $url = get_api_info(1,'internship/update'); //获取路由地址
                $res = request_api($url,$param,'put'); //更新实习经验
                break;
            case 'internship_del'://实习经验删除
                $param['id'] = I("post.id");//实习经验ID
                $url = get_api_info(1,'internship/del'); //获取路由地址
                $res = request_api($url,$param,'delete'); //删除实习经验
                break;
            case 'school_reword_create'://校内荣誉创建
                $syear = I("post.syear");
                $smonth = I("post.smonth");
                if (strlen($smonth) == 1){//格式是20100117
                    $param['get_time'] =  $syear.'0'.$smonth;//开始时间 
                }else{
                    $param['get_time'] =  $syear.$smonth;//开始时间 
                }
                $param['resume_id'] = I("post.resume_id");//简历ID
                $param['name'] = I("post.name");//名称
                $param['level'] = I("post.level");//级别
                $url = get_api_info(1,'school/reward/create'); //获取路由地址
                $res = request_api($url,$param,'post'); //创建校内荣誉
                break;
            case 'school_reword_update'://校内荣誉更新
                $syear = I("post.syear");
                $smonth = I("post.smonth");
                if (strlen($smonth) == 1){//格式是20100117
                    $param['get_time'] =  $syear.'0'.$smonth;//开始时间 
                }else{
                    $param['get_time'] =  $syear.$smonth;//开始时间 
                }
                $param['id'] = I("post.id");//荣誉ID
                $param['name'] = I("post.name");//名称
                $param['level'] = I("post.level");//级别
                $url = get_api_info(1,'school/reward/update'); //获取路由地址
                $res = request_api($url,$param,'put'); //创建校内荣誉
                break;
            case 'school_reword_del'://校内荣誉删除
                $param['id'] = I("post.id");//荣誉ID
                $url = get_api_info(1,'school/reward/del'); //获取路由地址
                $res = request_api($url,$param,'delete'); //删除校内荣誉
                break;
            case 'school_job_create'://校内职务创建
                $syear = I("post.syear");
                $smonth = I("post.smonth");
                $eyear = I("post.eyear");
                $emonth = I("post.emonth");
                if (strlen($smonth) == 1){//格式是20100117
                    $param['sdate'] =  $syear.'0'.$smonth;//开始时间 
                }else{
                    $param['sdate'] =  $syear.$smonth;//开始时间 
                }
                if ($eyear * $emonth !=0){//当毕业时间为空自动转为至今
                    if (strlen($emonth) == 1){//格式是20100117
                        $param['edate'] =  $eyear.'0'.$emonth;//结束时间 
                    }else{
                        $param['edate'] =  $eyear.$emonth;//结束时间 
                    }
                }else{
                    $param['edate'] = 0;
                }
                $param['resume_id'] = I("post.resume_id");//简历ID
                $param['role'] = I("post.role");//角色
                $param['remark'] = I("post.remark");//描述
                $url = get_api_info(1,'school/job/create'); //获取路由地址
                $res = request_api($url,$param,'post'); //创建校内荣誉
                break;
            case 'school_job_update'://校内职务更新
                $syear = I("post.syear");
                $smonth = I("post.smonth");
                $eyear = I("post.eyear");
                $emonth = I("post.emonth");
                if (strlen($smonth) == 1){//格式是20100117
                    $param['sdate'] =  $syear.'0'.$smonth;//开始时间 
                }else{
                    $param['sdate'] =  $syear.$smonth;//开始时间 
                }
                if ($eyear * $emonth !=0){//当毕业时间为空自动转为至今
                    if (strlen($emonth) == 1){//格式是20100117
                        $param['edate'] =  $eyear.'0'.$emonth;//结束时间 
                    }else{
                        $param['edate'] =  $eyear.$emonth;//结束时间 
                    }
                }else{
                    $param['edate'] = 0;
                }
                $param['id'] = I("post.id");//职务ID
                $param['role'] = I("post.role");//角色
                $param['remark'] = I("post.remark");//描述
                $url = get_api_info(1,'school/job/update'); //获取路由地址
                $res = request_api($url,$param,'put'); //更新校内荣誉
                break;
            case 'school_job_del'://校内职务删除
                $param['id'] = I("post.id");//职务ID
                $url = get_api_info(1,'school/job/del'); //获取路由地址
                $res = request_api($url,$param,'delete'); //删除校内职务
                break;
            case 'school_practice_create'://社会实践创建
                $syear = I("post.syear");
                $smonth = I("post.smonth");
                $eyear = I("post.eyear");
                $emonth = I("post.emonth");
                if (strlen($smonth) == 1){//格式是20100117
                    $param['sdate'] =  $syear.'0'.$smonth;//开始时间 
                }else{
                    $param['sdate'] =  $syear.$smonth;//开始时间 
                }
                if ($eyear * $emonth !=0){//当毕业时间为空自动转为至今
                    if (strlen($emonth) == 1){//格式是20100117
                        $param['edate'] =  $eyear.'0'.$emonth;//结束时间 
                    }else{
                        $param['edate'] =  $eyear.$emonth;//结束时间 
                    }
                }else{
                    $param['edate'] = 0;
                }
                $param['resume_id'] = I("post.resume_id");//简历ID
                $param['name'] = I("post.name");//实践名称
                $param['remark'] = I("post.remark");//描述
                $url = get_api_info(1,'school/practice/create'); //获取路由地址
                $res = request_api($url,$param,'post'); //创建社会实践
                break;
            case 'school_practice_update'://更新社会实践
                $syear = I("post.syear");
                $smonth = I("post.smonth");
                $eyear = I("post.eyear");
                $emonth = I("post.emonth");
                if (strlen($smonth) == 1){//格式是20100117
                    $param['sdate'] =  $syear.'0'.$smonth;//开始时间 
                }else{
                    $param['sdate'] =  $syear.$smonth;//开始时间 
                }
                if ($eyear * $emonth !=0){//当毕业时间为空自动转为至今
                    if (strlen($emonth) == 1){//格式是20100117
                        $param['edate'] =  $eyear.'0'.$emonth;//结束时间 
                    }else{
                        $param['edate'] =  $eyear.$emonth;//结束时间 
                    }
                }else{
                    $param['edate'] = 0;
                }
                $param['id'] = I("post.id");//实践ID
                $param['name'] = I("post.name");//实践名称
                $param['remark'] = I("post.remark");//描述
                $url = get_api_info(1,'school/practice/update'); //获取路由地址
                $res = request_api($url,$param,'put'); //更新社会实践
                break;
            case 'school_practice_del':
                $param['id'] = I("post.id");//实践
                $url = get_api_info(1,'school/practice/del'); //获取路由地址
                $res = request_api($url,$param,'delete'); //删除校内职务
                break;
		}
        if (isset($res['error_code']) && $res['error_code']=='unauthorized'){
			$data['status'] = 0;
			$data['msg'] = "登录出现异常";
        	$this->ajaxReturn($data,'json');
        }
        session('op_time',$op_time);
		
		if ($res['error_code'] != 'success'){
			$data['status'] = 0;
			$data['msg'] = $res['error_description'];
		}else{
			if ($type == 'intention_create' || $type == 'intention_update' && I('post.index') == 'index'){
				//事件名称
				$event_name = 'need_modify_intention';
				//更新用户未完成事件
				if(putDoneEvent($param['access_token'],$event_name)){
					session('member.is_intention_show',1);
					$data['event_msg'] = "未完成事件已更新";
				}else{
					$data['event_msg'] = "未完成事件更新失败";
				}
			}
            unset($param['access_token']);
            $data['res'] = $res;
            //$data['param'] = $param;
			$data['status'] = 1;
			$data['msg'] = "操作成功";
		}
		$this->ajaxReturn($data,'json');
	}
}










}